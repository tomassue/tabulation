<?php

namespace App\Livewire\Reference;

use App\Models\Category;
use Livewire\Component;
use App\Models\RefJudge;

class Judges extends Component
{
    public $id, $judge, $nickname, $selectedCategories = [], $selectedCateg;
    public function render()
    {
        $judges = RefJudge::all();
        if ($this->selectedCateg) {
            $judges = RefJudge::whereJsonContains('category', $this->selectedCateg)->get();
        }
        $categories = Category::where('is_active', 1)->get();
        return view('livewire.reference.judges', compact('judges', 'categories'));
    }
    public function addJudge()
    {
        $this->reset();
        $this->dispatch('openModal');
    }
    public function editJudge($id)
    {
        $this->id = $id;
        $judge = RefJudge::find($id);

        $this->judge = $judge->judge;
        $this->nickname = $judge->nickname;
        $this->selectedCategories = $judge->category;
        $this->dispatch('openModal');
    }
    public function saveJudge()
    {
        $this->validate([
            'judge' => 'required',
            'nickname' => 'required',
            'selectedCategories' => 'array',
            'selectedCategories.*' => 'exists:categories,category',
        ]);

        $judge = $this->id ? RefJudge::find($this->id) : new RefJudge();
        $judge->judge = $this->judge;
        $judge->nickname = $this->nickname;
        $judge->category = $this->selectedCategories;
        $judge->save();

        return session()->flash('status', 'Sucessfully saved!');
    }
}
