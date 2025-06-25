<?php

namespace App\Livewire;

use App\Models\RefCriteria;
use Livewire\Component;
use App\Models\RefParticipant;
use App\Models\RefJudge;

class Poster extends Component
{
    public function render()
    {
        $participants = RefParticipant::where('category', 'poster')->get();
        $judges = RefJudge::where('category', 'poster')->get();
        $criterias = RefCriteria::where('category', 'oral')->get();
        return view('livewire.poster', compact('participants', 'judges', 'criterias'));
    }
}
