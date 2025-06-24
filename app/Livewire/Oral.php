<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RefParticipant;
use App\Models\RefJudge;

class Oral extends Component
{
    public function render()
    {   
        $participants = RefParticipant::where('category','oral')->get();
        $judges = RefJudge::where('category','oral')->get();
        return view('livewire.oral',compact('participants','judges'));
    }
}
