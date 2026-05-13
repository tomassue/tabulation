<?php

namespace App\Models;

use App\Services\ReportService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RefParticipant extends Model
{
    protected $fillable = [
        'category',
        'participant_no',
        'participant',
        'school',
        'gender',
    ];
    protected $casts = [
        'category' => 'array', // Casts the 'details' column to a PHP array
    ];

    public function scopeCategory($query, $category)
    {
        return $query->whereJsonContains('ref_participants.category', $category);
    }
    public function sumRound1()
    {
        return $this->hasMany(QuizBee::class, 'participant_id')->where('round_id', 1)->sum('score');
    }

    public function sumRound2()
    {
        return $this->hasMany(QuizBee::class, 'participant_id')->where('round_id', 2)->sum('score');
    }

    public function sumRound3()
    {
        return $this->hasMany(QuizBee::class, 'participant_id')->where('round_id', 3)->sum('score');
    }
    public function sumRound4()
    {
        return $this->hasMany(QuizBee::class, 'participant_id')->where('round_id', 4)->sum('score');
    }

    public function sumAll()
    {
        return $this->hasMany(QuizBee::class, 'participant_id')->sum('score');
    }
    public function getPercent()
    {
        return $this->hasMany(QuizBee::class, 'participant_id')->where('round_id', '!=', 4)->whereNotNull('score')->count() / 25 * 100;
    }
    public function convert($path): String
    {
        if ($path) {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $image = base64_encode(file_get_contents($path));
            return "data:image/" . $ext . ";base64," . $image;
        } else {
            return "";
        }
    }
    public function getScore($judge_id)
    {
        return $this->hasMany(Oral::class, 'participant_id', 'id')->where('judge_id', $judge_id)->sum('score');
    }
    public function judgeTotalScore()
    {
        return $this->hasMany(Oral::class, 'participant_id', 'id')->sum('score');
    }
    public function deductions()
    {
        return $this->hasOne(OralDeduction::class, 'participant_id', 'id');
    }
    public function getPosterScore($judge_id)
    {
        return $this->hasMany(Poster::class, 'participant_id', 'id')->where('judge_id', $judge_id)->sum('score');
    }
    public function judgePosterTotalScore()
    {
        return $this->hasMany(Poster::class, 'participant_id', 'id')->sum('score');
    }
    public function posterOutput()
    {
        return $this->hasOne(PosterOutput::class, 'participant_id', 'id');
    }
    public function averagePoster()
    {
        return $this->hasMany(Poster::class, 'participant_id', 'id')->sum('score') / 3;
    }
    public function averageOral()
    {
        $deduction = $this->deductions?->deduction;
        return ($this->hasOne(Oral::class, 'participant_id', 'id')->sum('score') / 3) - $deduction;
    }
    public function averageHigalaay($category, $criteria = null)
    {
        $deduction = $this->higalaayDeduction($category)?->deduction ?? 0;

        // Single-criteria filter (used for per-criteria PDF views) — no weighting
        if ($criteria) {
            $relation = $this->hasMany(Higalaay::class, 'participant_id', 'id')
                ->where('criteria_id', $criteria->id)
                ->where('category', $category);
            if (Auth::user()->role == 'admin') {
                $judges = RefJudge::category($category)->count();
                return $judges > 0 ? $relation->sum('score') / $judges : 0;
            }
            $judge = RefJudge::where('user_id', Auth::user()->id)->category($category)->first();
            return $judge ? $relation->where('judge_id', $judge->id)->sum('score') : 0;
        }

        // Check for weighted segments
        $allCriterias = RefCriteria::where('category', $category)->get();
        $weighted = $allCriterias->whereNotNull('segment')->whereNotNull('segment_weight');

        if ($weighted->isNotEmpty()) {
            $judgeCount = RefJudge::category($category)->count();
            if ($judgeCount == 0) return 0;

            // For non-admin, only use that judge's scores
            $judgeId = null;
            if (Auth::user()->role !== 'admin') {
                $judge = RefJudge::where('user_id', Auth::user()->id)->category($category)->first();
                if (!$judge) return 0;
                $judgeId = $judge->id;
                $judgeCount = 1;
            }

            $total = 0;
            foreach ($weighted->groupBy('segment') as $segCriterias) {
                $segWeight   = $segCriterias->first()->segment_weight; // e.g. 20
                $segMax      = $segCriterias->sum('perfect_score');    // e.g. 100
                if ($segMax == 0) continue;

                $criteriaIds = $segCriterias->pluck('id');
                $query = $this->hasMany(Higalaay::class, 'participant_id', 'id')
                    ->where('category', $category)
                    ->whereIn('criteria_id', $criteriaIds);

                if ($judgeId) $query->where('judge_id', $judgeId);

                $segScore = $query->sum('score'); // sum across all judges in segment
                // (segScore / judgeCount) = avg judge score for segment (max = segMax)
                // normalize to weight: (avg / segMax) * segWeight
                $total += ($segScore / $judgeCount / $segMax) * $segWeight;
            }

            return round($total - $deduction, 4);
        }

        // Original unweighted average
        $relation = $this->hasMany(Higalaay::class, 'participant_id', 'id')->where('category', $category);
        if (Auth::user()->role == 'admin') {
            $judges = RefJudge::category($category)->count();
            return $judges > 0 ? ($relation->sum('score') / $judges) - $deduction : 0;
        }
        $judge = RefJudge::where('user_id', Auth::user()->id)->category($category)->first();
        return $judge ? ($relation->where('judge_id', $judge->id)->sum('score')) - $deduction : 0;
    }
    public function getHigalaayScoreByJudge($judge_id, $category,  $criteria =  null)
    {
        $relation = $this->hasMany(Higalaay::class, 'participant_id', 'id');
        if ($criteria) {
            $relation->where('criteria_id', $criteria->id);
        }
        return $relation->where('category', $category)->where('judge_id', $judge_id)->sum('score');
    }
    public function getRankingsByJudge($judge_id, $category, $participant_id)
    {
        $service = new ReportService($category, null, $judge_id);
        $participants = $service->generateTopParticipants();
        return $participants->where('id', $participant_id)->first()?->current_rank;
    }
    public function higalaayDeduction($category)
    {
        return $this->hasOne(HigalaayDeduction::class, 'participant_id', 'id')->where('category', $category)->first();
    }
    public function higalaayJudgesTotalScore($category)
    {
        return $this->hasMany(Higalaay::class, 'participant_id', 'id')->where('category', $category)->sum('score');
    }
    public function geTheHighestPoints($category)
    {
        return $this->hasMany(Higalaay::class, 'participant_id', 'id')->where('category', $category)->max('score');
    }
}
