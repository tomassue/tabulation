<?php

namespace App\Livewire;

use App\Models\LedManagement;
use App\Models\RefJudge;
use App\Models\RefParticipant;
use App\Services\ReportService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class DynamicLed extends Component
{
    public function render()
    {
        if (Auth::guest()) return abort(404);

        $led = LedManagement::first();
        if (!$led) return abort(404);
        $participants = [];
        $position = null;
        $participantsRaw = RefParticipant::groupBy('ref_participants.id')->category($led->category)->limit(3);
        if ($led->category == "quiz") {
            $participantsRaw =  $participantsRaw->leftjoin('quiz_bees', 'ref_participants.id', '=', 'quiz_bees.participant_id')
                ->orderByRaw('SUM(quiz_bees.score) DESC')
                ->select('ref_participants.*',  DB::raw('SUM(quiz_bees.score) as total_score'));
        } else if ($led->category == "oral") {
            $participantsRaw = $participantsRaw->leftjoin('orals', 'ref_participants.id', '=', 'orals.participant_id')
                ->leftjoin('oral_deductions', 'ref_participants.id', '=', 'oral_deductions.participant_id')
                ->groupBy([
                    'ref_participants.id',
                    'ref_participants.participant_no',
                    'ref_participants.participant',
                    'deduction'
                ])
                ->select(
                    'ref_participants.*',
                    DB::raw('SUM(orals.score) as total_score'),
                    DB::raw('COALESCE(oral_deductions.deduction, 0) as deduction'),
                    DB::raw('(SUM(orals.score) / 3 - COALESCE(oral_deductions.deduction, 0)) as final_score')
                )
                ->orderBy('final_score', 'DESC');
        } else if ($led->category == "poster") {
            $participantsRaw =  $participantsRaw->leftjoin('posters', 'ref_participants.id', '=', 'posters.participant_id')
                ->groupBy('ref_participants.id')
                ->select('ref_participants.*',  DB::raw('SUM(posters.score) / 3 as total_score'))
                ->orderBy('total_score', 'DESC');
        } else {
            $service = new ReportService($led->category);
            $participantsraw = $service->generateTopParticipants();
        }


        // Check which position to show with priority order
        $top = [];
        $winners = '';
        if ($led->show_third) {
            $participants = $participantsraw->where('current_rank',  3);
            $position = 3;
        } elseif ($led->show_second) {
            $participants = $participantsraw->where('current_rank',  2);
            $position = 2;
        } elseif ($led->show_first) {
            $participants = $participantsraw->where('current_rank',  1);
            $position = 1;
        } else {
            $participants = [];
        }

        if ($led->show_all) {
            foreach ($participantsraw as $participant) {
                if ($participant->current_rank == 4) {
                    break;
                }
                $top[] = $participant->participant . ' - ' . bong_ordinal_new($participant->current_rank);
            }
            $winners = implode(' <br/> ', $top);
        } else {
            foreach ($participants as $participant) {
                $top[] = $participant->participant;
            }
            $winners = implode(' & ', $top);
        }
        return view('livewire.dynamic-led', compact('led', 'winners', 'position'));
    }
}
