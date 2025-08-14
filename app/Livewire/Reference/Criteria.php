<?php

namespace App\Livewire\Reference;

use App\Models\Category;
use Livewire\Component;
use App\Models\RefCriteria;

class Criteria extends Component
{
    public $id, $criteria, $perfect_score, $category, $selectedCateg, $password;
    public function render()
    {
        $criterias = RefCriteria::where('category', 'LIKE', "%{$this->selectedCateg}%")->get();
        $categories = Category::where('is_active', 1)->get();
        return view('livewire.reference.criteria', compact('criterias', 'categories'));
    }
    public function addCriteria()
    {
        $this->reset();
        $this->dispatch('openModal');
    }
    public function editCriteria($id)
    {
        $this->id = $id;
        $criteria = RefCriteria::find($id);

        $this->criteria = $criteria->criteria;
        $this->perfect_score = $criteria->perfect_score;
        $this->category = $criteria->category;
        $this->dispatch('openModal');
    }
    public function saveCriteria()
    {
        $this->validate([
            'criteria' => 'required',
            'perfect_score' => 'required',
            'category' => 'required'
        ]);

        $criteria = $this->id ? RefCriteria::find($this->id) : new RefCriteria();
        $criteria->criteria = $this->criteria;
        $criteria->perfect_score = $this->perfect_score;
        $criteria->category = $this->category;
        $criteria->save();

        return session()->flash('status', 'Sucessfully saved!');
    }
    public function deleteCriteria($id)
    {
        $this->resetValidation();
        $this->id = $id;
        $this->dispatch('openDeleteModal');
    }
    public function executeDelete()
    {
        $this->validate([
            'password' => 'required|current_password',
        ]);

        $criteria = RefCriteria::find($this->id);
        if ($criteria) {
            $criteria->delete();
            $this->password = null;
            return session()->flash("status", "Sucessfully deleted!");
        }
        return session()->flash("error", "Failed to delete");
    }
}
