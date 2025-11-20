<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefCriteria extends Model
{
    protected $fillable = [
        'criteria',
        'perfect_score',
        'category',
    ];

    public function scopeCategory($query, $category)
    {
        return $query->where('ref_criterias.category', $category);
    }
}
