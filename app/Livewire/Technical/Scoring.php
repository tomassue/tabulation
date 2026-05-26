<?php

namespace App\Livewire\Technical;

use App\Models\Category;
use App\Models\Log;
use App\Models\RefJudge;
use App\Models\RefParticipant;
use App\Models\TechnicalCategory;
use App\Models\TechnicalDeduction;
use App\Models\TechnicalJudgeAssignment;
use App\Models\TechnicalScore;
use App\Models\TechnicalSubCriteria;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Scoring extends Component
{
    public string $type;
    public int $winner = 3;
    public string $base64pdf = '';

    // Participant search
    public string $search = '';
    public $selectedParticipant = null;
    public bool $showDropdown = false;
    public array $suggestions = [];

    // Tab state: 'scoring' | 'summary' | 'setup'
    public string $activeTab = 'scoring';

    // Which technical category is active in scoring tab (id)
    public $activeTechnicalCategoryId = null;

    // Deduction modal state
    public $deductionParticipantId = null;
    public array $deductionInputs = [];    // ['technical_minor' => count, ...]
    public array $deductionRemarks = [];   // ['technical_minor' => text, ...]

    // Setup: new technical category form
    public string $newCatName = '';
    public string $newCatSlug = '';
    public int $newCatMaxScore = 100;
    public int $newCatOrder = 0;

    // Setup: new sub-criteria form
    public $newSubCatId = null;
    public string $newSubGroup = '';
    public string $newSubName = '';
    public float $newSubMax = 10;
    public int $newSubOrder = 0;

    // Setup: judge assignment
    public $assignJudgeId = null;
    public $assignTechCatId = null;

    public function mount(string $type, int $winner = 3)
    {
        $this->type = $type;
        $this->winner = $winner;

        $first = TechnicalCategory::where('competition_category', $type)->orderBy('display_order')->first();
        if ($first) {
            $this->activeTechnicalCategoryId = $first->id;
        }

        // For a judge user, force to their assigned category
        if (Auth::user()->role !== 'admin') {
            $judge = RefJudge::where('user_id', Auth::id())->first();
            if ($judge) {
                $assignment = TechnicalJudgeAssignment::where('judge_id', $judge->id)
                    ->whereHas('technicalCategory', fn($q) => $q->where('competition_category', $type))
                    ->first();
                if ($assignment) {
                    $this->activeTechnicalCategoryId = $assignment->technical_category_id;
                }
            }
        }
    }

    public function render()
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'admin';

        $technicalCategories = TechnicalCategory::where('competition_category', $this->type)
            ->with(['subCriterias', 'judgeAssignments.judge'])
            ->orderBy('display_order')
            ->get();

        // Active category for scoring
        $activeCategory = $technicalCategories->firstWhere('id', $this->activeTechnicalCategoryId)
            ?? $technicalCategories->first();

        // Determine which judge is scoring the active category
        $activeCategoryJudge = null;
        if ($activeCategory) {
            $assignment = $activeCategory->judgeAssignments->first();
            $activeCategoryJudge = $assignment?->judge;
        }

        // Judge: restrict to their assigned categories only
        $judgeAssignedCategoryIds = collect();
        if (!$isAdmin) {
            $judge = RefJudge::where('user_id', Auth::id())->first();
            $myAssignments = TechnicalJudgeAssignment::where('judge_id', $judge?->id)
                ->whereHas('technicalCategory', fn($q) => $q->where('competition_category', $this->type))
                ->get();
            $judgeAssignedCategoryIds = $myAssignments->pluck('technical_category_id');

            if ($judgeAssignedCategoryIds->isNotEmpty()) {
                // If current selection isn't one of theirs, fall back to their first
                if (!$judgeAssignedCategoryIds->contains($this->activeTechnicalCategoryId)) {
                    $this->activeTechnicalCategoryId = $judgeAssignedCategoryIds->first();
                }
                $activeCategory = $technicalCategories->firstWhere('id', $this->activeTechnicalCategoryId);
            }
            $activeCategoryJudge = $judge;
        }

        $participants = RefParticipant::when($this->selectedParticipant, fn($q) => $q->where('id', $this->selectedParticipant))
            ->category($this->type)
            ->orderBy('participant_no')
            ->get();

        $categoryName = Category::where('category', $this->type)->first();

        // Summary: total scores per participant
        $summaryData = null;
        if ($this->activeTab === 'summary') {
            $summaryData = $this->buildSummaryData($participants, $technicalCategories);
        }

        // Setup: all judges for assignment
        $allJudges = $isAdmin ? RefJudge::category($this->type)->get() : collect();

        return view('livewire.technical.scoring', compact(
            'technicalCategories',
            'activeCategory',
            'activeCategoryJudge',
            'participants',
            'categoryName',
            'isAdmin',
            'summaryData',
            'allJudges',
            'judgeAssignedCategoryIds',
        ));
    }

    // ───────────── Participant search ─────────────

    public function updatedSearch()
    {
        if (strlen($this->search) > 2) {
            $this->suggestions = RefParticipant::where('participant', 'like', '%' . $this->search . '%')
                ->category($this->type)
                ->limit(5)
                ->get()
                ->toArray();
            $this->showDropdown = true;
        } else {
            $this->suggestions = [];
            $this->selectedParticipant = null;
            $this->showDropdown = false;
        }
    }

    public function selectSuggestion($id)
    {
        $item = RefParticipant::find($id);
        if ($item) {
            $this->search = $item->participant;
            $this->selectedParticipant = $id;
            $this->showDropdown = false;
        }
    }

    // ───────────── Score saving ─────────────

    public function saveScore($participant_id, $sub_criteria_id, $judge_id, $score)
    {
        $sub = TechnicalSubCriteria::find($sub_criteria_id);
        $score = is_numeric($score) ? (float) $score : 0;
        if ($sub && $score > $sub->max_score) {
            $score = $sub->max_score;
        }
        if ($score < 0) $score = 0;

        TechnicalScore::updateOrCreate(
            [
                'participant_id'       => $participant_id,
                'judge_id'             => $judge_id,
                'sub_criteria_id'      => $sub_criteria_id,
                'competition_category' => $this->type,
            ],
            ['score' => $score]
        );

        Log::create([
            'user_id'  => Auth::id(),
            'activity' => "Technical score saved — participant #{$participant_id}, sub_criteria #{$sub_criteria_id}, judge #{$judge_id}, score: {$score}",
        ]);
    }

    // ───────────── Deduction modal ─────────────

    public function openDeductionModal($participant_id)
    {
        $this->deductionParticipantId = $participant_id;
        $this->deductionInputs  = [];
        $this->deductionRemarks = [];

        foreach (array_keys(TechnicalDeduction::$pointsMap) as $type) {
            $existing = TechnicalDeduction::where('participant_id', $participant_id)
                ->where('competition_category', $this->type)
                ->where('type', $type)
                ->first();
            $this->deductionInputs[$type]  = $existing?->count ?? 0;
            $this->deductionRemarks[$type] = $existing?->remarks ?? '';
        }

        $this->dispatch('openDeductionModal');
    }

    public function saveDeductions()
    {
        foreach (TechnicalDeduction::$pointsMap as $type => $pts) {
            $count = (int) ($this->deductionInputs[$type] ?? 0);
            TechnicalDeduction::updateOrCreate(
                [
                    'participant_id'       => $this->deductionParticipantId,
                    'competition_category' => $this->type,
                    'type'                 => $type,
                ],
                [
                    'count'            => $count,
                    'total_deduction'  => $count * $pts,
                    'remarks'          => $this->deductionRemarks[$type] ?? null,
                ]
            );
        }

        session()->flash('status', 'Deductions saved successfully.');
        $this->dispatch('closeDeductionModal');
    }

    // ───────────── Setup (admin) ─────────────

    public function addTechnicalCategory()
    {
        $this->validate([
            'newCatName'     => 'required|string|max:100',
            'newCatSlug'     => 'required|string|max:50',
            'newCatMaxScore' => 'required|integer|min:1',
        ]);

        $cat = TechnicalCategory::create([
            'competition_category' => $this->type,
            'name'                 => $this->newCatName,
            'slug'                 => $this->newCatSlug,
            'max_score'            => $this->newCatMaxScore,
            'display_order'        => $this->newCatOrder,
        ]);

        $this->activeTechnicalCategoryId = $cat->id;
        $this->reset(['newCatName', 'newCatSlug', 'newCatMaxScore', 'newCatOrder']);
        session()->flash('setup_status', 'Judging category added.');
    }

    public function deleteTechnicalCategory($id)
    {
        TechnicalCategory::destroy($id);
        $first = TechnicalCategory::where('competition_category', $this->type)->orderBy('display_order')->first();
        $this->activeTechnicalCategoryId = $first?->id;
        session()->flash('setup_status', 'Judging category deleted.');
    }

    public function addSubCriteria()
    {
        $this->validate([
            'newSubCatId' => 'required|exists:technical_categories,id',
            'newSubName'  => 'required|string|max:100',
            'newSubMax'   => 'required|numeric|min:0.5',
        ]);

        TechnicalSubCriteria::create([
            'technical_category_id' => $this->newSubCatId,
            'sub_group'             => $this->newSubGroup ?: null,
            'name'                  => $this->newSubName,
            'max_score'             => $this->newSubMax,
            'display_order'         => $this->newSubOrder,
        ]);

        $this->reset(['newSubGroup', 'newSubName', 'newSubMax', 'newSubOrder']);
        session()->flash('setup_status', 'Sub-criteria added.');
    }

    public function deleteSubCriteria($id)
    {
        TechnicalSubCriteria::destroy($id);
        session()->flash('setup_status', 'Sub-criteria deleted.');
    }

    public function assignJudge()
    {
        $this->validate([
            'assignJudgeId'   => 'required|exists:ref_judges,id',
            'assignTechCatId' => 'required|exists:technical_categories,id',
        ]);

        TechnicalJudgeAssignment::updateOrCreate(
            ['technical_category_id' => $this->assignTechCatId],
            ['judge_id' => $this->assignJudgeId]
        );

        $this->reset(['assignJudgeId', 'assignTechCatId']);
        session()->flash('setup_status', 'Judge assigned.');
    }

    public function removeJudgeAssignment($technicalCategoryId)
    {
        TechnicalJudgeAssignment::where('technical_category_id', $technicalCategoryId)->delete();
        session()->flash('setup_status', 'Judge assignment removed.');
    }

    // ───────────── PDF report ─────────────

    public function generateReport()
    {
        $category = Category::where('category', $this->type)->firstOrFail();

        $technicalCategories = TechnicalCategory::where('competition_category', $this->type)
            ->with(['subCriterias', 'judgeAssignments.judge'])
            ->orderBy('display_order')
            ->get();

        $participants = RefParticipant::category($this->type)->orderBy('participant_no')->get();
        $rows = $this->buildSummaryData($participants, $technicalCategories);

        $options = new Options();
        $options->set('isRemoteEnabled', false);

        $html = view('generated_pdf.technical-result', compact(
            'category',
            'technicalCategories',
            'rows',
        ) + ['winner' => $this->winner])->render();

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('folio', 'landscape');
        $dompdf->render();

        $canvas      = $dompdf->getCanvas();
        $fontMetrics = $dompdf->getFontMetrics();
        $font        = $fontMetrics->getFont('Arial', 'normal');
        $canvas->page_text(830, 570, 'Page {PAGE_NUM} of {PAGE_COUNT}', $font, 10, [0, 0, 0]);

        $this->base64pdf = base64_encode($dompdf->output());
        $this->dispatch('openReportModal');
    }

    // ───────────── Summary builder ─────────────

    private function buildSummaryData($participants, $technicalCategories): array
    {
        $rows = [];
        foreach ($participants as $p) {
            $categoryScores = [];
            $grandTotal = 0;

            foreach ($technicalCategories as $tc) {
                $score = $tc->participantScore($p->id);
                $categoryScores[$tc->id] = $score;
                $grandTotal += $score;
            }

            $totalDeduction = TechnicalDeduction::totalFor($p->id, $this->type);
            $finalScore = max(0, $grandTotal - $totalDeduction);

            $rows[] = [
                'participant'     => $p,
                'categoryScores'  => $categoryScores,
                'grandTotal'      => $grandTotal,
                'totalDeduction'  => $totalDeduction,
                'finalScore'      => $finalScore,
            ];
        }

        // Sort by final score descending
        usort($rows, fn($a, $b) => $b['finalScore'] <=> $a['finalScore']);

        // Assign dense ranks
        $rank = 1;
        $prev = null;
        $sameCount = 0;
        foreach ($rows as $i => &$row) {
            if ($prev !== null && $row['finalScore'] === $prev) {
                $row['rank'] = $rows[$i - $sameCount - 1]['rank'];
                $sameCount++;
            } else {
                $row['rank'] = $rank;
                $sameCount = 0;
            }
            $prev = $row['finalScore'];
            $rank++;
        }
        unset($row);

        return $rows;
    }
}
