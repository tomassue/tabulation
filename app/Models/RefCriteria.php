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
}
