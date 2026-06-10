<?php

namespace App\Livewire;

use App\Models\LedManagement;
use Livewire\Component;

class DynamicLed extends Component
{
    public function render()
    {
        $led = LedManagement::with(['firstParticipant', 'secondParticipant', 'thirdParticipant', 'fourthParticipant'])->first();
        if (!$led) return abort(404);

        $participants = collect();
        $position = null;
        $winners = '';

        if ($led->show_all) {
            $ranked = collect([
                1 => $led->firstParticipant,
                2 => $led->secondParticipant,
                3 => $led->thirdParticipant,
                4 => $led->fourthParticipant,
            ])->filter();

            $top = [];
            foreach ($ranked as $rank => $participant) {
                $participant->current_rank = $rank;
                $top[] = $participant->participant . ' - ' . bong_ordinal_new($rank);
            }
            $participants = $ranked->values();
            $winners = implode(' <br/> ', $top);

        } elseif ($led->show_first && $led->firstParticipant) {
            $position = 1;
            $participants = collect([$led->firstParticipant]);
            $winners = $led->firstParticipant->participant;

        } elseif ($led->show_second && $led->secondParticipant) {
            $position = 2;
            $participants = collect([$led->secondParticipant]);
            $winners = $led->secondParticipant->participant;

        } elseif ($led->show_third && $led->thirdParticipant) {
            $position = 3;
            $participants = collect([$led->thirdParticipant]);
            $winners = $led->thirdParticipant->participant;

        } elseif (($led->show_fourth ?? false) && $led->fourthParticipant) {
            $position = 4;
            $participants = collect([$led->fourthParticipant]);
            $winners = $led->fourthParticipant->participant;
        }

        return view('livewire.dynamic-led', compact('led', 'participants', 'winners', 'position'));
    }
}
