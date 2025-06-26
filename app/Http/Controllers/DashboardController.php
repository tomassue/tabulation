<?php

namespace App\Http\Controllers;

use App\Models\RefCriteria;
use App\Models\RefParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        //PROGRESS RATE
        $quizProgress = RefParticipant::leftjoin('quiz_bees', 'quiz_bees.participant_id', 'ref_participants.id')
            ->where('ref_participants.category', 'quiz')
            ->whereNotNull('quiz_bees.score')->count() / 25 * 100;

        $criOral = RefCriteria::where('category', 'oral')->count();
        $oralProgress = $criOral != 0 ? RefParticipant::leftjoin('orals', 'orals.participant_id', 'ref_participants.id')
            ->where('ref_participants.category', 'oral')
            ->whereNotNull('orals.score')->count() / $criOral * 100 : 0;

        $critPoster = RefCriteria::where('category', 'poster')->count();
        $posterProgress = $critPoster != 0 ? RefParticipant::leftjoin('posters', 'posters.participant_id', 'ref_participants.id')
            ->where('ref_participants.category', 'poster')
            ->whereNotNull('posters.score')->count() / $critPoster * 100 : 0;

        //TOP SCORES
        $topPoster = RefParticipant::where('category', 'poster')
            ->leftjoin('posters', 'ref_participants.id', '=', 'posters.participant_id')
            ->groupBy('ref_participants.id')
            ->orderByRaw('SUM(posters.score) DESC')
            ->select('ref_participants.*',  DB::raw('SUM(posters.score) as total_score'))
            ->limit(3)->get();

        $topQuiz = RefParticipant::where('category', 'quiz')
            ->leftjoin('quiz_bees', 'ref_participants.id', '=', 'quiz_bees.participant_id')
            ->groupBy('ref_participants.id')
            ->orderByRaw('SUM(quiz_bees.score) DESC')
            ->select('ref_participants.*',  DB::raw('SUM(quiz_bees.score) as total_score'))
            ->limit(3)
            ->get();

        $topOral = RefParticipant::where('category', 'oral')
            ->leftjoin('orals', 'ref_participants.id', '=', 'orals.participant_id')
            ->leftjoin('oral_deductions', 'ref_participants.id', '=', 'oral_deductions.participant_id')
            ->groupBy([
                'ref_participants.id',
                'ref_participants.participant_no',
                'ref_participants.participant',
                'deduction'
            ])
            ->select(
                'ref_participants.*',
                DB::raw('SUM(orals.score) as total_score'),
                DB::raw('COALESCE(oral_deductions.deduction, 0) as deduction'),
                DB::raw('(SUM(orals.score) - COALESCE(oral_deductions.deduction, 0)) as final_score')
            )
            ->orderBy('final_score', 'DESC')
            ->limit(3)
            ->get();
        //COMPLETION RATE
        return view('dashboard', compact('quizProgress', 'oralProgress', 'posterProgress', 'topPoster', 'topQuiz', 'topOral'));
    }
}
