<?php

namespace App\Livewire;

use App\Models\RefCriteria;
use Livewire\Component;
use App\Models\RefParticipant;
use App\Models\RefJudge;
use App\Models\Oral as OralModel;
use Barryvdh\DomPDF\Facade\Pdf;

class Oral extends Component
{
    public $search = '', $base64pdf, $judge_id;
    public function render()
    {
        $participants = RefParticipant::where('participant', 'like', '%' . $this->search . '%')->where('category', 'oral')->get();
        $judges = RefJudge::where('category', 'oral')->get();
        $criterias = RefCriteria::where('category', 'oral')->get();
        $part = RefParticipant::where('category', 'oral')->get();
        return view('livewire.oral', compact('participants', 'judges', 'criterias', 'part'));
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
    public function generateReport()
    {
        $paper = array(0, 0, 1400, 850);
        $judge = RefJudge::find($this->judge_id);
        $participants = RefParticipant::where('category', 'oral')->get();
        $oral = OralModel::all();
        $criterias = RefCriteria::where('category', 'oral')->get();
        $pdf = Pdf::loadView('generated_pdf.oratorical', compact('participants', 'oral', 'criterias', 'judge'))->setPaper('letter', 'landscape');
        $this->base64pdf = base64_encode($pdf->output());
        $this->dispatch('openModal');
    }
}
