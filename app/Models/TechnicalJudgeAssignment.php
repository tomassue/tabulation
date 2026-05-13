<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalJudgeAssignment extends Model
{
    protected $fillable = ['judge_id', 'technical_category_id'];

    public function judge()
    {
        return $this->belongsTo(RefJudge::class, 'judge_id');
    }

    public function technicalCategory()
    {
        return $this->belongsTo(TechnicalCategory::class, 'technical_category_id');
    }
}
