<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalCategory extends Model
{
    protected $fillable = ['competition_category', 'name', 'slug', 'max_score', 'display_order'];

    public function subCriterias()
    {
        return $this->hasMany(TechnicalSubCriteria::class)->orderBy('display_order');
    }

    public function judgeAssignments()
    {
        return $this->hasMany(TechnicalJudgeAssignment::class);
    }

    public function assignedJudge()
    {
        return $this->hasOneThrough(RefJudge::class, TechnicalJudgeAssignment::class, 'technical_category_id', 'id', 'id', 'judge_id');
    }

    /** Sum of sub-criteria scores for a participant in this category. */
    public function participantScore($participant_id): float
    {
        $subIds = $this->subCriterias()->pluck('id');
        return TechnicalScore::whereIn('sub_criteria_id', $subIds)
            ->where('participant_id', $participant_id)
            ->where('competition_category', $this->competition_category)
            ->sum('score');
    }

    /** Completion percentage: how many sub-criteria have been scored across all participants. */
    public function completionPercent($competition_category): float
    {
        $subIds = $this->subCriterias()->pluck('id');
        $participants = RefParticipant::category($competition_category)->count();
        $total = $subIds->count() * $participants;
        if ($total === 0) return 0;
        $filled = TechnicalScore::whereIn('sub_criteria_id', $subIds)
            ->where('competition_category', $competition_category)
            ->where('score', '>', 0)
            ->count();
        return round(($filled / $total) * 100, 1);
    }
}
