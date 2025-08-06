<?php

namespace App\Livewire\Settings;

use App\Exports\HigalaayExport;
use App\Imports\HigalaayImport;
use App\Livewire\Higalaay;
use App\Models\Category;
use App\Models\Higalaay as ModelsHigalaay;
use App\Models\RefJudge;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class DBImportExport extends Component
{
    use WithFileUploads;
    public $category_name, $judge_id, $excel_file, $count;
    public function render()
    {
        $categories = Category::where('is_active', 1)->get();
        $judges = RefJudge::whereJsonContains('category', $this->category_name)->get();
        return view('livewire.settings.db-import-export', compact('judges', 'categories'));
    }
    public function updatedJudge()
    {
        $this->count = ModelsHigalaay::where('category', $this->category_name)->where('judge_id', $this->judge_id)->count();
    }
    public function exportDatabase()
    {
        $this->validate([
            'category_name' => 'required',
            'judge_id' => 'required',
        ]);
        return Excel::download(new HigalaayExport($this->category_name, $this->judge_id), 'higalaay.xlsx');
    }
    public function importDatabase()
    {
        $this->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv',
        ]);
        Excel::import(new HigalaayImport($this->category_name, $this->judge_id),  $this->excel_file);
        session()->flash('message', 'File imported successfully!');
        $this->excel_file = null; // Clear the file input
    }
}
