<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Higalaay extends Model
{
    protected $table = 'higalaays';

    protected $fillable = [
        'participant_id',
        'score',
        'category',
        'criteria_id',
        'judge_id',
    ];
}
