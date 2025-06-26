<?php

namespace App\Http\Controllers;

use App\Models\RefParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DisplayController extends Controller
{
    public function oral()
    {
        $participants = RefParticipant::where('category', 'oral')
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

        return view('led_display.oral', compact('participants'));
    }
}
