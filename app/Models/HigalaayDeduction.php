<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HigalaayDeduction extends Model
{
    protected $fillable = [
        'participant_id',
        'deduction',
        'remarks',
        'deduction_details',
        'duration'
    ];
    protected $casts = [
        'deduction_details' => 'array', // Casts the 'details' column to a PHP array
    ];
    public function scopeDeduction($query, $deduction)
    {
        return $query->whereJsonContains('higalaay_deductions.deduction_details', $deduction);
    }
    public function participant()
    {
        return $this->hasOne(RefParticipant::class, 'id', 'participant_id');
    }
}
