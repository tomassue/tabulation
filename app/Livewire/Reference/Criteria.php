<?php

namespace App\Livewire\Reference;

use Livewire\Component;
use App\Models\RefCriteria;

class Criteria extends Component
{   
    public $id, $criteria, $perfect_score;
    public function render()
    {
        $criterias = RefCriteria::all();
        return view('livewire.reference.criteria', compact('criterias'));
    }
    public function addCriteria(){
        $this->reset();
        $this->dispatch('openModal');
    }
    public function editCriteria($id){
        $this->id = $id;
        $criteria = RefCriteria::find($id);
        
        $this->criteria = $criteria->criteria;
        $this->perfect_score = $criteria->perfect_score;
        $this->dispatch('openModal');
    }
    public function saveCriteria(){
        $this->validate([
            'criteria' => 'required',
            'perfect_score' => 'required',
        ]);

        $criteria = $this->id ? RefCriteria::find($this->id) : new RefCriteria();
        $criteria->criteria = $this->criteria;
        $criteria->perfect_score = $this->perfect_score;

        $criteria->save();

        return session()->flash('status', 'Sucessfully saved!');
    }
}
