<?php

namespace App\Livewire\Reference;

use App\Models\Category;
use App\Models\RefDeduction;
use Livewire\Component;

class Deductions extends Component
{
    public $id, $deduction_name, $deduction, $category, $selectedCateg, $password;

    public function render()
    {
        $deductions = RefDeduction::where('category', 'LIKE', "%{$this->selectedCateg}%")->get();
        $categories = Category::where('is_active', 1)->get();
        return view('livewire.reference.deductions', compact('categories', 'deductions'));
    }
    public function addDeduction()
    {
        $this->reset();
        $this->dispatch('openModal');
    }
    public function editDeduction($id)
    {
        $this->id = $id;
        $deduction = RefDeduction::find($id);

        $this->deduction_name = $deduction->deduction_name;
        $this->deduction = $deduction->deduction;
        $this->category = $deduction->category;
        $this->dispatch('openModal');
    }
    public function saveDeduction()
    {
        $this->validate([
            'deduction_name' => 'required',
            'deduction' => 'required',
            'category' => 'required'
        ]);

        $deduction = $this->id ? RefDeduction::find($this->id) : new RefDeduction();
        $deduction->deduction_name = $this->deduction_name;
        $deduction->deduction = $this->deduction;
        $deduction->category = $this->category;
        $deduction->save();

        return session()->flash('status', 'Sucessfully saved!');
    }
    public function deleteDeduction($id)
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

        $deduction = RefDeduction::find($this->id);
        if ($deduction) {
            $deduction->delete();
            $this->password = null;
            return session()->flash("status", "Sucessfully deleted!");
        }
        return session()->flash("error", "Failed to delete");
    }
}
