<?php

namespace App\Http\Controllers;

use App\Models\PosterOutput;
use App\Models\RefParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DisplayPosterController extends Controller
{
    public function poster()
    {
        $participants = RefParticipant::where('category', 'poster')
            ->leftjoin('posters', 'ref_participants.id', '=', 'posters.participant_id')
            ->groupBy('ref_participants.id')
            ->select('ref_participants.*',  DB::raw('SUM(posters.score) / 3 as total_score'))
            ->orderby('total_score', 'DESC')
            ->limit(3)->get();
            

        return view('led_display.poster', compact('participants'));
    }

    public function output($id)
    {
        $file = PosterOutput::where('participant_id', $id)->first()->output_file;
        return view('led_display.poster_output', compact('file'));
    }
}
