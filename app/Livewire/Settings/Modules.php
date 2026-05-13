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
        $display_participant,
        $is_active,
        $winners,
        $tabulation_mode = 'average';

    public function rules()
    {
        return [
            'category' => 'required',
            'description' => 'required',
            'winners' => 'required',
            'is_active' => 'required',
            'display_participant' => 'required',
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
                    'winners' => $this->winners,
                    'is_active' => $this->is_active,
                    'display_participant' => $this->display_participant,
                    'tabulation_mode' => $this->tabulation_mode,
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
        $module = Category::findOrFail($id);
        $this->category_id = $module->id;
        $this->category = $module->category;
        $this->description = $module->description;
        $this->winners = $module->winners;
        $this->is_active = $module->is_active;
        $this->display_participant = $module->display_participant;
        $this->tabulation_mode = $module->tabulation_mode ?? 'average';

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
