<?php

namespace App\Livewire;

use App\Models\RefCriteria;
use Livewire\Component;
use App\Models\RefParticipant;
use App\Models\RefJudge;
use App\Models\Oral as OralModel;
use App\Models\OralDeduction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class Oral extends Component
{
    public $search = '', $base64pdf, $judge_id;
    public function render()
    {
        $participants = RefParticipant::where('participant_no', 'like', '%' . $this->search . '%')->where('category', 'oral')->get();
        $judges = RefJudge::where('id', 'like', '%' . $this->judge_id . '%')->where('category', 'oral')->get();
        $criterias = RefCriteria::where('category', 'oral')->get();
        $part = RefParticipant::where('category', 'oral')->get();
        $jud  = RefJudge::where('category', 'oral')->get();
        return view('livewire.oral', compact('participants', 'judges', 'criterias', 'part', 'jud'));
    }
    public function saveScore($participant_id, $criteria_id, $judge_id, $score)
    {
        $oral = OralModel::where('participant_id', $participant_id)->where('criteria_id', $criteria_id)->where('judge_id', $judge_id)->first();
        if (!$oral) {
            $oral = new OralModel();
            $oral->participant_id = $participant_id;
            $oral->criteria_id = $criteria_id;
            $oral->judge_id = $judge_id;
        }
        $oral->score = $score;
        $oral->save();
    }
    public function saveDeduction($participant_id, $score)
    {
        $deduction = OralDeduction::where('participant_id', $participant_id)->first();
        if (!$deduction) {
            $deduction = new OralDeduction();
            $deduction->participant_id = $participant_id;
        }
        $deduction->deduction = $score;
        $deduction->save();
    }
    public function generateReport()
    {
        $paper = array(0, 0, 1400, 850);
        $judges = RefJudge::where('category', 'oral')->get();
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
            ->get();

        $oral = OralModel::all();
        $criterias = RefCriteria::where('category', 'oral')->get();
        $pdf = Pdf::loadView('generated_pdf.oratorical', compact('participants', 'oral', 'criterias', 'judges'))->setPaper('letter', 'portrait');
        $this->base64pdf = base64_encode($pdf->output());
        $this->dispatch('openModal');
    }
}
