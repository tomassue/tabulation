<?php

namespace App\Livewire;

use App\Models\RefCriteria;
use Livewire\Component;
use App\Models\RefParticipant;
use App\Models\RefJudge;
use App\Models\Poster as PosterModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class Poster extends Component
{
    public $search = '', $base64pdf; 
    public function render()
    {
        $participants = RefParticipant::where('participant', 'like', '%' . $this->search . '%')->where('category', 'poster')->get();
        $judges = RefJudge::where('category', 'poster')->get();
        $criterias = RefCriteria::where('category', 'poster')->get();
        $part = RefParticipant::where('category', 'poster')->get();
        return view('livewire.poster', compact('participants', 'judges', 'criterias','part'));
    }
    public function saveScore($participant_id, $criteria_id, $judge_id, $score)
    {
        $poster = PosterModel::where('participant_id', $participant_id)->where('criteria_id', $criteria_id)->where('judge_id', $judge_id)->first();
        if (!$poster) {
            $poster = new PosterModel();
            $poster->participant_id = $participant_id;
            $poster->criteria_id = $criteria_id;
            $poster->judge_id = $judge_id;
        }
        $poster->score = $score;
        $poster->save();
    }
    public function generateReport()
    {
        $paper = array(0, 0, 1400, 850);
        $judges = RefJudge::where('category', 'poster')->get();
        $participants = RefParticipant::where('category', 'poster')
            ->leftjoin('posters', 'ref_participants.id', '=', 'posters.participant_id')
            ->groupBy('ref_participants.id')
            ->orderByRaw('SUM(posters.score) DESC')
            ->select('ref_participants.*',  DB::raw('SUM(posters.score) as total_score'))
            ->get();
        $poster = PosterModel::all();
        $criterias = RefCriteria::where('category', 'poster')->get();
        $pdf = Pdf::loadView('generated_pdf.poster', compact('participants', 'poster', 'criterias', 'judges'))->setPaper('letter', 'landscape');
        $this->base64pdf = base64_encode($pdf->output());
        $this->dispatch('openModal');
    }
}
