<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Higalaay as ModelsHigalaay;
use App\Models\HigalaayDeduction;
use App\Models\Log;
use App\Models\RefCriteria;
use App\Models\RefJudge;
use App\Models\RefParticipant;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Higalaay extends Component
{
    public $type, $winner;
    public $search, $judge_id, $base64pdf = '';
    public function render()
    {
        $participants = RefParticipant::where('participant_no', 'like', '%' . $this->search . '%')->category($this->type)->get();
        $part = RefParticipant::category($this->type)->get();
        $criterias = RefCriteria::where('category', $this->type)->get();

        if (Auth::user()->role == 'admin') {
            $judges = RefJudge::where('id', 'like', '%' . $this->judge_id . '%')->category($this->type)->get();
        } else {
            $judges = RefJudge::where('user_id', Auth::user()->id)->category($this->type)->get();
        }

        $jud  = RefJudge::category($this->type)->get();
        $categoryName = Category::where('category', $this->type)->pluck('description')->first();
        return view('livewire.higalaay', compact('jud', 'judges', 'part', 'participants', 'criterias', 'categoryName'));
    }
    public function saveScore($participant_id, $criteria_id, $judge_id, $score)
    {
        $higalaay = ModelsHigalaay::where('participant_id', $participant_id)->where('category', $this->type)->where('criteria_id', $criteria_id)->where('judge_id', $judge_id)->first();
        if (!$higalaay) {
            $higalaay = new ModelsHigalaay();
            $higalaay->participant_id = $participant_id;
            $higalaay->criteria_id = $criteria_id;
            $higalaay->judge_id = $judge_id;
            $higalaay->category = $this->type;
        }
        $oldScore = $higalaay->score;
        $higalaay->score = $score ? $score : 0;
        $higalaay->save();

        Log::create([
            'user_id' => Auth::user()->id,
            'activity' => $this->type . ' Higalaay id ' . $higalaay->id . ' Score has been updated from ' . $oldScore . ' to ' . $higalaay->score,
        ]);
    }
    public function generateReport()
    {
        $paper = array(0, 0, 850, 1400);
        $category = $this->type;
        $winner =  $this->winner;

        $user = Auth::user();
        $isAdmin = ($user->role == 'admin');

        //get judges base on user role
        if ($isAdmin) {
            $judges = RefJudge::category($this->type)->get();
        } else {
            $judges = RefJudge::where('user_id', Auth::user()->id)->category($this->type)->get();
        }

        // Determine divisor for score calculation
        $divisor = $isAdmin ? ($judges->count() ?: 1) : 1;  // Prevent division by zero

        $participantsraw = RefParticipant::category($this->type);

        if (!$isAdmin) {
            $judge = RefJudge::where('user_id', Auth::user()->id)->category($this->type)->first();
            $participantsraw->where('judge_id', $judge->id);
        }

        $participants = $participantsraw->select('ref_participants.*', DB::raw('DENSE_RANK() OVER (ORDER BY (SUM(higalaays.score) /' . $divisor . ' - COALESCE(higalaay_deductions.deduction, 0)) DESC) as current_rank'))
            ->leftjoin('higalaays', 'ref_participants.id', '=', 'higalaays.participant_id')
            ->leftjoin('higalaay_deductions', 'ref_participants.id', '=', 'higalaay_deductions.participant_id')
            ->groupBy('ref_participants.id', 'deduction')
            ->get();

        $poster = ModelsHigalaay::all();

        $criterias = RefCriteria::where('category',  $this->type)->get();
        $categoryName = Category::where('category', $this->type)->pluck('description')->first();

        $pdf = Pdf::loadView('generated_pdf.higalaay', compact('participants', 'poster', 'criterias', 'judges', 'category', 'categoryName', 'winner'))->setPaper('letter', 'landscape');
        $this->base64pdf = base64_encode($pdf->output());
        $this->dispatch('openModal');
    }
    public function saveDeduction($participant_id, $score)
    {
        $deduction = HigalaayDeduction::where('participant_id', $participant_id)->first();
        if (!$deduction) {
            $deduction = new HigalaayDeduction();
            $deduction->participant_id = $participant_id;
        }
        $deduction->deduction = $score && $score != null ? $score : 0;
        $deduction->save();
    }
}
