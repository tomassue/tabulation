<?php

namespace App\Livewire\Reports\Component;

use App\Models\Category;
use App\Models\RefCriteria;
use App\Models\RefJudge;
use App\Models\RefParticipant;
use Livewire\Component;
use Dompdf\Dompdf;
use Dompdf\Options;

class EventRankingByJudge extends Component
{
    public $selectedCategory, $percentage = false,  $showDeduction = false, $base64pdf;
    public function render()
    {
        $categories = Category::where('is_active', 1)->get();
        return view('livewire.reports.component.event-ranking-by-judge', compact('categories'));
    }
    public function generateReport()
    {
        $this->validate([
            'selectedCategory' => 'required',
        ]);

        $category = Category::where('category', $this->selectedCategory)->first();
        $participants = RefParticipant::category($this->selectedCategory)->get();
        $judges =  RefJudge::category($this->selectedCategory)->get();
        $criterias = RefCriteria::category($this->selectedCategory)->get();

        $percentage = $this->percentage;
        $showDeduction = $this->showDeduction;
        $isWeighted = $criterias->whereNotNull('segment')->whereNotNull('segment_weight')->isNotEmpty();

        $grands = $this->caculateRankings($participants, $category, $judges, $criterias, $isWeighted);

        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $htmlContent = view('generated_pdf.judge-ranking-summary', compact('category', 'judges', 'percentage', 'showDeduction', 'isWeighted', 'grands'))->render();
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($htmlContent);
        $dompdf->setPaper('folio', 'landscape');
        $dompdf->render();

        $canvas = $dompdf->getCanvas();
        $fontMetrics = $dompdf->getFontMetrics();
        $font = $fontMetrics->getFont("Arial", "normal");
        $size = 10;
        $canvas->page_text(
            850,                 // X position
            10,                 // Y position
            "Page {PAGE_NUM} of {PAGE_COUNT}",
            $font,
            $size,
            [0, 0, 0], // Color in RGB [0, 0, 0]
        );

        $this->base64pdf = base64_encode($dompdf->output());
        $this->dispatch('openRankingModal');
    }
    private function caculateRankings($participants, $category, $judges, $criterias, $isWeighted)
    {
        $grands = [];
        $segmentedCriterias = $isWeighted ? $criterias->groupBy('segment') : collect();

        foreach ($participants as $item) {
            $part = [
                'participant_no' => $item->participant_no,
                'participant'    => $item->participant,
                'judge_scores'   => [],
                'deduction'      => $item->higalaayDeduction($category->category)?->deduction ?? 0,
                'subtotals'      => $item->higalaayJudgesTotalScore($category->category),
                'grand'          => $item->averageHigalaay($category->category),
            ];

            foreach ($judges as $judge) {
                if ($isWeighted) {
                    $weightedScore = 0;
                    foreach ($segmentedCriterias as $segCriterias) {
                        $segWeight = $segCriterias->first()->segment_weight;
                        $segMax    = $segCriterias->sum('perfect_score');
                        if ($segMax == 0) continue;
                        $segRaw = $item->getHigalaayScoreByJudge($judge->id, $category->category);
                        // sum only this segment's criteria for this judge
                        $segRaw = 0;
                        foreach ($segCriterias as $criteria) {
                            $segRaw += $item->getHigalaayScoreByJudge($judge->id, $category->category, $criteria);
                        }
                        $weightedScore += ($segRaw / $segMax) * $segWeight;
                    }
                    $part['judge_scores'][$judge->user_id] = round($weightedScore, 4);
                } else {
                    $part['judge_scores'][$judge->user_id] = $item->getHigalaayScoreByJudge($judge->id, $category->category) ?: 0;
                }
            }

            $grands[] = $part;
        }

        $grands = bong_rank_arranger($grands, 'grand', 'ordinal_rank', true, "DESC");
        return $grands;
    }
}
