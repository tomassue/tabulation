<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Higalaay as ModelsHigalaay;
use App\Models\HigalaayDeduction;
use App\Models\Log;
use App\Models\RefCriteria;
use App\Models\RefDeduction;
use App\Models\RefJudge;
use App\Models\RefParticipant;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Higalaay extends Component
{
    public $type, $winner;
    public $search, $selectedParticipant, $judge_id, $criteria_id, $base64pdf = '';
    public $showDropdown = false;
    public $suggestions = [];
    public $deductionModel, $refDeductions = [];
    public $remarks, $duration, $oldDeductions, $totalDeductions = 0, $deductionSelected;
    public function render()
    {
        $selected = $this->selectedParticipant;
        $participants = RefParticipant::when(!empty($selected), function ($query) use ($selected) {
            $query->where('id', $selected);
        })->category($this->type)->get();

        $criterias = RefCriteria::where('category', $this->type)->get();

        if (Auth::user()->role == 'admin') {
            $judges = RefJudge::where('id', 'like', '%' . $this->judge_id . '%')->category($this->type)->get();
        } else {
            $judges = RefJudge::where('user_id', Auth::user()->id)->category($this->type)->get();
        }

        $jud  = RefJudge::category($this->type)->get();
        $categoryName = Category::where('category', $this->type)->pluck('description')->first();
        $this->calculateTotals();
        return view('livewire.higalaay', compact('jud', 'judges', 'participants', 'criterias', 'categoryName'));
    }
    public function updatedSearch()
    {
        if (strlen($this->search) > 2) {

            $this->suggestions  = RefParticipant::where('participant', 'like', '%' . $this->search . '%')->category($this->type)
                ->limit(5) // Limit suggestions
                ->get();
            $this->showDropdown = true;
        } else {
            $this->suggestions = [];
            $this->selectedParticipant = null;
            $this->showDropdown = false;
        }
    }
    public function selectSuggestion($id)
    {
        $selectedItem = RefParticipant::find($id);
        if ($selectedItem) {
            $this->search = $selectedItem->participant;
            $this->selectedParticipant = $id;
            $this->showDropdown = false;
        }
    }
    public function saveScore($participant_id, $criteria_id, $judge_id, $score)
    {
        $criteria = RefCriteria::find($criteria_id);
        if ($criteria && $score > $criteria->perfect_score) {
            $score = $criteria->perfect_score;
        }

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
            $participantsraw->where('higalaays.judge_id', $judge->id);
        }
        if ($this->criteria_id) {
            $participantsraw->where('higalaays.criteria_id', $this->criteria_id);
        }
        $participants = $participantsraw->select('ref_participants.*', DB::raw('DENSE_RANK() OVER (ORDER BY (SUM(higalaays.score) /' . $divisor . ' - COALESCE(higalaay_deductions.deduction, 0)) DESC) as current_rank'))
            ->leftJoin('higalaays', function ($join) {
                $join->on('ref_participants.id', '=', 'higalaays.participant_id')
                    ->where('higalaays.category', $this->type);
            })
            ->leftJoin('higalaay_deductions', function ($join) {
                $join->on('ref_participants.id', '=', 'higalaay_deductions.participant_id')
                    ->where('higalaay_deductions.category', $this->type);
            })
            ->groupBy('ref_participants.id', 'deduction')
            ->get();

        $poster = ModelsHigalaay::all();

        $criteria = RefCriteria::find($this->criteria_id);
        $categoryName = Category::where('category', $this->type)->pluck('description')->first();

        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $htmlContent = view('generated_pdf.higalaay', compact('participants', 'poster',  'judges', 'category', 'criteria', 'categoryName', 'winner'))->render();
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($htmlContent);
        $dompdf->setPaper('folio', 'landscape');
        $dompdf->render();

        $canvas = $dompdf->getCanvas();
        $fontMetrics = $dompdf->getFontMetrics();
        $font = $fontMetrics->getFont("Arial", "normal");
        $size = 10;
        $canvas->page_text(
            830,                 // X position
            570,                 // Y position
            "Page {PAGE_NUM} of {PAGE_COUNT}",
            $font,
            $size,
            [0, 0, 0], // Color in RGB [0, 0, 0]
        );

        $this->base64pdf = base64_encode($dompdf->output());
        // $pdf = Pdf::loadView('generated_pdf.higalaay', compact('participants', 'poster',  'judges', 'category', 'criteria', 'categoryName', 'winner'))->setPaper('folio', 'landscape');
        // $this->base64pdf = base64_encode($pdf->output());
        $this->dispatch('openModal');
    }
    public function saveDeduction($participant_id, $score)
    {
        $deduction = HigalaayDeduction::where('category', $this->type)->where('participant_id', $participant_id)->first();
        if (!$deduction) {
            $deduction = new HigalaayDeduction();
            $deduction->participant_id = $participant_id;
        }
        $deduction->deduction = $score && $score != null ? $score : 0;
        $deduction->category = $this->type;
        $deduction->save();
    }
    public function showDeductionDetails($participant_id)
    {
        $this->deductionSelected = $participant_id;

        $deduction = HigalaayDeduction::where('category', $this->type)->firstOrNew(['participant_id' => $participant_id]);
        $existingDetails = $deduction->deduction_details ?? [];

        // Create a lookup map for existing details [id => checked]
        $detailMap = collect($existingDetails)->pluck('checked', 'id')->all();

        // Fetch reference deductions with checked status
        $this->refDeductions = RefDeduction::where('category', $this->type)
            ->get()
            ->map(function ($deduction) use ($detailMap) {
                return [
                    'id' => $deduction->id,
                    'deduction_name' => $deduction->deduction_name,
                    'deduction' => $deduction->deduction,
                    'checked' => $detailMap[$deduction->id] ?? false,
                    // Include other fields you need
                ];
            })
            ->toArray();

        $this->deductionModel = $deduction;
        $this->oldDeductions = $deduction->deduction;
        $this->remarks = $deduction->remarks;
        $this->duration = $deduction->duration;
        $this->dispatch('openDetailsModal');
    }

    public function updated()
    {
        $this->calculateTotals();
    }
    private function calculateTotals()
    {
        if ($this->refDeductions)
            $this->totalDeductions =  collect($this->refDeductions)
                ->where('checked', false)
                ->sum('deduction');
    }
    public function saveCustomDeductions()
    {
        $this->validate([
            'refDeductions' => 'array',
            'remarks' => 'required',
            'duration' => 'required'
        ]);

        $deduction = HigalaayDeduction::where('category', $this->type)->where('participant_id',  $this->deductionSelected)->first();
        if (!$deduction) {
            $deduction = new HigalaayDeduction();
            $deduction->participant_id =  $this->deductionSelected;
        }

        if ($this->totalDeductions != null) {
            $deduction->deduction = $this->totalDeductions;
        }

        $deduction->deduction_details = $this->refDeductions;
        $deduction->category = $this->type;
        $deduction->remarks = $this->remarks;
        $deduction->duration = $this->duration;
        $deduction->save();

        return session()->flash('status', 'Sucessfully updated!');
    }
}
