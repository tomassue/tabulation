<?php

namespace App\Imports;

use App\Models\Higalaay;
use App\Models\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HigalaayImport implements ToCollection, WithHeadingRow
{
    protected $judge_id, $category_name;

    public function __construct($category_name, $judge_id)
    {
        $this->category_name = $category_name;
        $this->judge_id = $judge_id;
    }
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $exist = Higalaay::where('participant_id', $row['participant_id'])
                ->where('category', $row['category'])
                ->where('judge_id',  $row['judge_id'])
                ->where('criteria_id', $row['criteria_id'])
                ->first();

            if ($exist) {
                continue;
            }

            Higalaay::create([
                'participant_id'    => $row['participant_id'],
                'score'             => $row['score'],
                'category'          => $row['category'],
                'criteria_id'       => $row['criteria_id'],
                'judge_id'          => $row['judge_id'],
            ]);

            Log::create([
                'user_id' => Auth::user()->id,
                'activity' => $row['category'] . ' imported with judge ' . $row['judge_id'] . ' Score  to ' . $row['score'],
            ]);
        }
    }
}
