<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RefParticipant;

class Quiz extends Component
{
    public function render()
    {   
        $participants = RefParticipant::where('category','quiz')->get();
        return view('livewire.quiz',compact('participants'));
    }
}
