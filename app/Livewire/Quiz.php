<?php

namespace App\Livewire;

use App\Models\QuizBee;
use Livewire\Component;
use App\Models\RefParticipant;

class Quiz extends Component
{
    public $search = '';
    public function render()
    {
        $participants = RefParticipant::where('participant', 'like', '%' . $this->search . '%')->where('category', 'quiz')->get();
        $part = RefParticipant::where('category', 'quiz')->get();
        $quizbees = QuizBee::all();
        return view('livewire.quiz', compact('participants', 'part', 'quizbees'));
    }
    public function saveScore($participant_id, $round_id, $question_number, $score)
    {
        $assessment = QuizBee::where('participant_id', $participant_id)->where('round_id', $round_id)->where('question_number', $question_number)->first();
        if (!$assessment) {
            $assessment = new QuizBee();
            $assessment->participant_id = $participant_id;
            $assessment->round_id = $round_id;
            $assessment->question_number = $question_number;
        }
        $assessment->score = $score ? $score : null;
        $assessment->save();
    }
}
