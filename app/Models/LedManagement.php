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
        'show_fourth',
        'first_id',
        'second_id',
        'third_id',
        'fourth_id',
    ];

    public function firstParticipant()
    {
        return $this->belongsTo(\App\Models\RefParticipant::class, 'first_id');
    }

    public function secondParticipant()
    {
        return $this->belongsTo(\App\Models\RefParticipant::class, 'second_id');
    }

    public function thirdParticipant()
    {
        return $this->belongsTo(\App\Models\RefParticipant::class, 'third_id');
    }

    public function fourthParticipant()
    {
        return $this->belongsTo(\App\Models\RefParticipant::class, 'fourth_id');
    }
}
