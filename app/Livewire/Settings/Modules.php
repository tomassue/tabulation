<?php

namespace App\Livewire\Settings;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use function Laravel\Prompts\error;

class Modules extends Component
{
    use WithPagination;
    # Filter
    public $selectedStatus;

    # Properties
    public $category_id;
    public $category,
        $description,
        $is_active;

    public function rules()
    {
        return [
            'category' => 'required',
            'description' => 'required',
            'is_active' => 'required',
        ];
    }

    public function updated($propertyName)
    {
        if ($propertyName == 'selectedStatus') {
            $this->resetPage();
        }
    }

    public function clear()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function addModule()
    {
        $this->dispatch('openModal');
    }

    public function render()
    {
        $data = [
            'modules' => $this->getModules(),
        ];

        return view('livewire.settings.modules', $data);
    }

    public function getModules()
    {
        $modules = Category::when($this->selectedStatus !== '' && $this->selectedStatus !== null, function ($query) {
            $query->where('is_active', $this->selectedStatus);
        })
            ->paginate(5);

        return $modules;
    }

    public function saveModule()
    {
        $this->validate();

        try {
            Category::updateOrCreate(
                ['id' => $this->category_id],
                [
                    'category' => Str::slug($this->category),
                    'description' => $this->description,
                    'is_active' => $this->is_active,
                    'icon' => '<i class="bi bi-box-seam"></i>'
                ]
            );
        } catch (\Throwable $th) {
            //throw $th;
            return error($th->getMessage());
        }
    }

    public function editModule($id)
    {
        $this->category_id = $id;
        $this->category = Category::find($id)->category;
        $this->description = Category::find($id)->description;
        $this->is_active = Category::find($id)->is_active;

        $this->dispatch('openModal');
    }

    public function deactivateModule($id)
    {
        Category::where('id', $id)->update(['is_active' => 0]);
    }

    public function activateModule($id)
    {
        Category::where('id', $id)->update(['is_active' => 1]);
    }
}
