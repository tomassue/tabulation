<?php

namespace App\Livewire\Reference;

use Livewire\Component;
use App\Models\RefQuizRound;

class QuizRound extends Component
{   
    public $id, $round;

    public function render()
    {   
        $rounds = RefQuizRound::all();
        return view('livewire.reference.quiz-round',compact('rounds'));
    }
       
    public function saveRound(){
        $this->validate([
            'round' => 'required',
        ]);
        $round = $this->id ? RefQuizRound::find($this->id) : new RefQuizRound();
        $round->round = $this->round;
        $round->save();

        $this->id = null;

        return session()->flash("status", "Successfully saved");
    }
    public function addRound(){
        $this->reset();
        $this->dispatch('openModal');
    }
    public function editRound($id){
        $round =  RefQuizRound::find($id);
        $this->round = $round->round;
        $this->id = $id;
        $this->dispatch('openModal');
    }
}
