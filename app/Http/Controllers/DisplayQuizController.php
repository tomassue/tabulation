<?php

namespace App\Http\Controllers;

use App\Models\RefParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DisplayQuizController extends Controller
{
    public function quiz()
    {
        $participants = RefParticipant::where('category', 'quiz')
            ->leftjoin('quiz_bees', 'ref_participants.id', '=', 'quiz_bees.participant_id')
            ->groupBy('ref_participants.id')
            ->orderByRaw('SUM(quiz_bees.score) DESC')
            ->select('ref_participants.*',  DB::raw('SUM(quiz_bees.score) as total_score'))
            ->limit(3)
            ->get();

        return view('led_display.quiz', compact('participants'));
    }
}
