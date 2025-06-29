<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';

    protected $fillable = [
        'activity',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
