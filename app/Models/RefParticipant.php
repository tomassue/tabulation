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
    public function getScore($judge_id)
    {
        return $this->hasMany(Oral::class, 'participant_id', 'id')->where('judge_id', $judge_id)->sum('score');
    }
    public function judgeTotalScore()
    {
        return $this->hasMany(Oral::class, 'participant_id', 'id')->sum('score');
    }
    public function deductions()
    {
        return $this->hasOne(OralDeduction::class, 'participant_id', 'id');
    }
    public function getPosterScore($judge_id)
    {
        return $this->hasMany(Poster::class, 'participant_id', 'id')->where('judge_id', $judge_id)->sum('score');
    }
    public function judgePosterTotalScore()
    {
        return $this->hasMany(Poster::class, 'participant_id', 'id')->sum('score');
    }
    public function posterOutput()
    {
        return $this->hasOne(PosterOutput::class, 'participant_id', 'id');
    }
    public function averagePoster()
    {
        return $this->hasMany(Poster::class, 'participant_id', 'id')->sum('score') / 3;
    }
    public function averageOral()
    {
        $dedecution = $this->deductions?->deduction;
        return ($this->hasOne(Oral::class, 'participant_id', 'id')->sum('score') - $dedecution)  / 3;
    }
}
