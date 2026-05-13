<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalDeduction extends Model
{
    protected $fillable = ['participant_id', 'competition_category', 'type', 'count', 'total_deduction', 'remarks'];

    public static array $pointsMap = [
        'technical_minor' => 1,
        'technical_major' => 3,
        'penalty'         => 10,
    ];

    public static array $labels = [
        'technical_minor' => 'Technical Minor (1pt each)',
        'technical_major' => 'Technical Major (3pt each)',
        'penalty'         => 'Penalty (10pt each)',
    ];

    public function participant()
    {
        return $this->belongsTo(RefParticipant::class, 'participant_id');
    }

    /** Total deduction points for all types for a given participant + competition. */
    public static function totalFor($participant_id, $competition_category): float
    {
        return static::where('participant_id', $participant_id)
            ->where('competition_category', $competition_category)
            ->sum('total_deduction');
    }
}
