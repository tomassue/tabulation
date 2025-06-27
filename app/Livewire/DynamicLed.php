<?php

namespace App\Livewire;

use App\Models\LedManagement;
use App\Models\RefParticipant;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DynamicLed extends Component
{
    public function render()
    {
        $led = LedManagement::first();
        $participants = [];
        $position = null;
        $participantsRaw = RefParticipant::groupBy('ref_participants.id')->where('category', $led->category)->limit(3);
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
        }


        // Check which position to show with priority order
        if ($led->show_third) {
            $participants = $participantsRaw->skip(2)->take(1)->get();
            $position = 3;
        } elseif ($led->show_second) {
            $participants = $participantsRaw->skip(1)->take(1)->get();
            $position = 2;
        } elseif ($led->show_first) {
            $participants = $participantsRaw->take(1)->get();
            $position = 1;
        } elseif ($led->show_all) {
            $participants = $participantsRaw->get();
        }
        return view('livewire.dynamic-led', compact('led', 'participants', 'position'));
    }
}
