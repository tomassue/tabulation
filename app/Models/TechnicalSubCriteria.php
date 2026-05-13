<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalSubCriteria extends Model
{
    protected $fillable = ['technical_category_id', 'sub_group', 'name', 'max_score', 'display_order'];

    public function technicalCategory()
    {
        return $this->belongsTo(TechnicalCategory::class);
    }
}
