<?php

namespace App\Livewire\Reference;

use Livewire\Component;
use App\Models\RefParticipant;

class Participants extends Component
{
    public $id, $participant, $category, $school, $participant_no;
    public function render()
    {
        $participants = RefParticipant::all();
        return view('livewire.reference.participants', compact('participants'));
    }
    
    public function saveParticipant(){
        $this->validate([
            'participant_no' => 'required',
            'participant' => 'required',
            'category' => 'required',
            'school' => 'required'
        ]);
        $participant = $this->id ? RefParticipant::find($this->id) : new RefParticipant();
        $participant->participant = $this->participant;
        $participant->category = $this->category;
        $participant->participant_no = $this->participant_no;
        $participant->school = $this->school;
        $participant->save();

        $this->id = null;

        return session()->flash("status", "Successfully saved");
    }
    public function addParticipant(){
        $this->reset();
        $this->dispatch('openModal');
    }
    public function editParticipant($id){
        $participant =  RefParticipant::find($id);
        $this->participant = $participant->participant;
        $this->category = $participant->category;
        $this->participant_no = $participant->participant_no;
        $this->school = $participant->school;
        $this->id = $id;
        $this->dispatch('openModal');
    }
}
