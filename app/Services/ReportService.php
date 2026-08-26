<?php

namespace App\Services;

use App\Models\RefJudge;
use App\Models\RefParticipant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public $type, $judges, $criteria_id = null, $byJudge = null, $applyJudgeDeduction = false;
    public function __construct($type, $criteria_id = null, $byJudge = null, $applyJudgeDeduction = false)
    {
        $this->type = $type;
        $this->criteria_id = $criteria_id;
        $this->byJudge = $byJudge;
        // Only used by the byJudge branch: spreads a participant's deduction evenly
        // across the panel and subtracts that share before ranking. Defaults to
        // false so existing callers keep their current behavior.
        $this->applyJudgeDeduction = $applyJudgeDeduction;
    }
    public function generateTopParticipants(): Collection
    {

        $user = Auth::user();
        $isAdmin = ($user->role == 'admin');

        //get judges base on user role
        if ($isAdmin && $this->byJudge == null) {
            $this->judges = RefJudge::active()->category($this->type)->get();
        } else {
            //get judges base on byJudge
            if ($this->byJudge) {
                $this->judges = RefJudge::where('user_id', $this->byJudge)->category($this->type)->get();
            } else {
                $this->judges = RefJudge::where('user_id', Auth::user()->id)->category($this->type)->get();
            }
        }
        // Determine divisor for score calculation
        $divisor = $isAdmin ? ($this->judges->count() ?: 1) : 1;  // Prevent division by zero

        // Get participants By Category
        $participantsraw = RefParticipant::category($this->type);

        // Filter participants if not admin
        if (!$isAdmin) {
            //get judges base on byJudge
            $judge = RefJudge::where('user_id', Auth::user()->id)->category($this->type)->first();
            $participantsraw->where('higalaays.judge_id', $judge->id);
        }
        if ($this->byJudge) {
            $judge = RefJudge::where('user_id', $this->byJudge)->category($this->type)->first();
            $participantsraw->where('higalaays.judge_id', $judge->id);
        }


        // Apply criteria_id filter and determine the current rank
        if ($this->criteria_id && $this->byJudge == null) {

            // Filter participants based on criteria_id without deduction
            $participantsraw->where('higalaays.criteria_id', $this->criteria_id)
                ->select('ref_participants.*', DB::raw('DENSE_RANK() OVER (ORDER BY (SUM(higalaays.score) /' . $divisor . ') DESC) as current_rank'));
        } elseif ($this->byJudge) {
            if ($this->applyJudgeDeduction) {
                // Spread the deduction evenly across the panel and subtract that
                // share from this judge's score before ranking. $this->judges was
                // narrowed to the single selected judge above, so the panel size
                // needs its own count. Rounded to 4dp to match the PHP-side score
                // printed in the report, so rank and displayed score agree.
                $panelSize = (int) (RefJudge::active()->category($this->type)->count() ?: 1);
                // The share is ROUNDed before subtracting, mirroring the PHP in
                // EventRankingByRank exactly. Rounding after the subtraction instead
                // would diverge: `deduction` is an INT column, so MySQL evaluates
                // the quotient in integer context and the two sides disagree
                // (e.g. 100 - 5/3 gives 99 in SQL vs 98.3333 in PHP).
                $participantsraw->select('ref_participants.*', DB::raw('DENSE_RANK() OVER (ORDER BY (SUM(higalaays.score) - ROUND(COALESCE(higalaay_deductions.deduction, 0) / ' . $panelSize . ', 4)) DESC) as current_rank'));
            } else {
                // Filter participants based on criteria_id without deduction
                $participantsraw->select('ref_participants.*', DB::raw('DENSE_RANK() OVER (ORDER BY (SUM(higalaays.score)) DESC) as current_rank'));
            }
        } else {

            // Calculate current rank with deduction
            $participantsraw->select('ref_participants.*', DB::raw('DENSE_RANK() OVER (ORDER BY (SUM(higalaays.score) /' . $divisor . ' - COALESCE(higalaay_deductions.deduction, 0)) DESC) as current_rank'));
        }

        // Join higalaays and higalaay_deductions tables
        $participants = $participantsraw->leftJoin('higalaays', function ($join) {
            $join->on('ref_participants.id', '=', 'higalaays.participant_id')
                ->where('higalaays.category', $this->type);
        })
            ->leftJoin('higalaay_deductions', function ($join) {
                $join->on('ref_participants.id', '=', 'higalaay_deductions.participant_id')
                    ->where('higalaay_deductions.category', $this->type);
            })
            ->groupBy('ref_participants.id', 'deduction')
            ->get();

        //return participants
        return $participants;
    }
}
