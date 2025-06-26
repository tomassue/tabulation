<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosterOutput extends Model
{
    protected $table = 'poster_outputs';

    protected $fillable = [
        'participant_id',
        'output_file',
    ];
}
