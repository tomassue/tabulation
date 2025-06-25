<?php

namespace App\Livewire\Reference;

use Livewire\Component;
use App\Models\RefJudge;

class Judges extends Component
{
    public $id, $judge, $nickname, $category;
    public function render()
    {   
        $judges = RefJudge::all();
        return view('livewire.reference.judges',compact('judges'));
    }
    public function addJudge(){
        $this->reset();
        $this->dispatch('openModal');
    }
    public function editJudge($id){
        $this->id = $id;
        $judge = RefJudge::find($id);
        
        $this->judge = $judge->judge;
        $this->nickname = $judge->nickname;
        $this->category = $judge->category;
        $this->dispatch('openModal');
    }
    public function saveJudge(){
        $this->validate([
            'judge' => 'required',
            'nickname' => 'required',
            'category' => 'required'
        ]);

        $judge = $this->id ? RefJudge::find($this->id) : new RefJudge();
        $judge->judge = $this->judge;
        $judge->nickname = $this->nickname;
        $judge->category = $this->category;
        $judge->save();

        return session()->flash('status', 'Sucessfully saved!');
    }
}
