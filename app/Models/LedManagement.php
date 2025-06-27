<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LedManagement extends Model
{
    protected $fillable = [
        'category',
        'show_all',
        'show_first',
        'show_second',
        'show_third',
    ];
}
