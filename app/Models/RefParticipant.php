<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefParticipant extends Model
{
    public function sumRound1()
    {
        return $this->hasMany(QuizBee::class, 'participant_id')->where('round_id', 1)->sum('score');
    }

    public function sumRound2()
    {
        return $this->hasMany(QuizBee::class, 'participant_id')->where('round_id', 2)->sum('score');
    }

    public function sumRound3()
    {
        return $this->hasMany(QuizBee::class, 'participant_id')->where('round_id', 3)->sum('score');
    }
    public function sumRound4()
    {
        return $this->hasMany(QuizBee::class, 'participant_id')->where('round_id', 4)->sum('score');
    }

    public function sumAll()
    {
        return $this->hasMany(QuizBee::class, 'participant_id')->sum('score');
    }
    public function getPercent()
    {
        return $this->hasMany(QuizBee::class, 'participant_id')->where('round_id', '!=', 4)->whereNotNull('score')->count() / 25 * 100;
    }
    public function convert($path): String
    {
        if ($path) {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $image = base64_encode(file_get_contents($path));
            return "data:image/" . $ext . ";base64," . $image;
        } else {
            return "";
        }
    }
}
