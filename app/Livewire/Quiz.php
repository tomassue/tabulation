<?php

namespace App\Livewire;

use App\Models\Log;
use App\Models\QuizBee;
use Livewire\Component;
use App\Models\RefParticipant;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Quiz extends Component
{
    public $search = '', $base64pdf;
    public function render()
    {
        $participants = RefParticipant::where('school', 'like', '%' . $this->search . '%')->where('category', 'quiz')->get();
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
        Log::create([
            'user_id' => Auth::user()->id,
            'activity' => 'Quiz id ' . $assessment->id . ' Score has been updated from ' . $assessment->score . ' to ' . $score,
        ]);
        $assessment->score = $score ? $score : 0;
        $assessment->save();
    }
    public function generateReport()
    {
        $paper = array(0, 0, 1400, 850);
        $participants = RefParticipant::where('category', 'quiz')
            ->leftjoin('quiz_bees', 'ref_participants.id', '=', 'quiz_bees.participant_id')
            ->groupBy('ref_participants.id')
            ->orderByRaw('SUM(quiz_bees.score) DESC')
            ->select('ref_participants.*',  DB::raw('SUM(quiz_bees.score) as total_score'))
            ->get();
        $quizbees = QuizBee::all();
        $pdf = Pdf::loadView('generated_pdf.quiz-bee', compact('participants', 'quizbees'))->setPaper($paper);
        $this->base64pdf = base64_encode($pdf->output());
        $this->dispatch('openModal');
    }
}
