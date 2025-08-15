<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefDeduction extends Model
{
    protected $fillable = [
        'category',
        'deduction_name',
        'deduction',
        'checked',
        'is_active'
    ];
}
