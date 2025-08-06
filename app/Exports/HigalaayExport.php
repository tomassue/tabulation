<?php

namespace App\Exports;

use App\Models\Higalaay;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HigalaayExport implements FromCollection, WithHeadings
{
    protected $judge_id, $category_name;

    public function __construct($category_name, $judge_id)
    {
        $this->category_name = $category_name;
        $this->judge_id = $judge_id;
    }
    public function collection()
    {
        return Higalaay::where('category', $this->category_name)
            ->where('judge_id', $this->judge_id)
            ->select('participant_id', 'score', 'category', 'criteria_id', 'judge_id')
            ->get();
    }
    public function headings(): array
    {
        return ["participant_id", "score", "category", "criteria_id", "judge_id"];
    }
}
