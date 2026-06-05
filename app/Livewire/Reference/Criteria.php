<?php

namespace App\Livewire\Reference;

use App\Models\Category;
use Livewire\Component;
use App\Models\RefCriteria;
use Livewire\WithPagination;

class Criteria extends Component
{
    use WithPagination;

    public $id, $criteria, $perfect_score, $category, $segment, $segment_weight, $selectedCateg, $password;
    public function render()
    {
        $criterias = RefCriteria::where('category', 'LIKE', "%{$this->selectedCateg}%")->orderBy('id', 'desc')->paginate(10);
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
        $this->segment = $criteria->segment;
        $this->segment_weight = $criteria->segment_weight;
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
        $criteria->segment = $this->segment ?: null;
        $criteria->segment_weight = $this->segment_weight ? (int) $this->segment_weight : null;
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
