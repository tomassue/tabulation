<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RefParticipant;
use App\Models\RefJudge;

class Poster extends Component
{
    public function render()
    {
        $participants = RefParticipant::where('category','poster')->get();
        $judges = RefJudge::where('category','poster')->get();
        return view('livewire.poster',compact('participants','judges'));
    }
}
