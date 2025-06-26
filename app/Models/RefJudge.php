<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefJudge extends Model
{
    public function getPercent()
    {
        $criterias = RefCriteria::where('category', 'poster')->count();
        $participant = RefParticipant::where('category', 'poster')->count();
        $total = $participant * $criterias;
        if ($total == 0) {
            return 0;
        }
        return $this->hasMany(Poster::class, 'judge_id')->whereNotNull('score')->count() / $total * 100;
    }
    public function getOralPercent()
    {
        $criterias = RefCriteria::where('category', 'oral')->count();
        $participant = RefParticipant::where('category', 'oral')->count();
        $total = $participant * $criterias;
        if ($total == 0) {
            return 0;
        }
        return $this->hasMany(Oral::class, 'judge_id')->whereNotNull('score')->count() / $total * 100;
    }
}
