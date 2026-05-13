<?php

namespace App\Livewire\Reports\Component;

use App\Models\Category;
use App\Models\RefCriteria;
use App\Models\RefJudge;
use App\Models\RefParticipant;
use App\Services\ReportService;
use Livewire\Component;
use Dompdf\Dompdf;
use Dompdf\Options;

class EventRankingByRank extends Component
{
    public $selectedCategory, $percentage = "0", $showDeduction = false,  $base64pdf;
    public function render()
    {
        $categories = Category::where('is_active', 1)->get();
        return view('livewire.reports.component.event-ranking-by-rank', compact('categories'));
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
        $isWeighted = $criterias->whereNotNull('segment')->whereNotNull('segment_weight')->isNotEmpty();

        $grands = $this->calculateRankings($participants, $judges, $category, $criterias, $isWeighted);
        $showDeduction = $this->showDeduction;

        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $htmlContent = view("generated_pdf.judge-ranking-rank-summary", compact('category', 'judges', 'percentage', 'isWeighted', 'grands', 'showDeduction'))->render();

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
        $this->dispatch('openRankingByRankModal');
    }

    private function calculateRankings($participants, $judges, $category, $criterias, $isWeighted)
    {
        $grands = [];
        $segmentedCriterias = $isWeighted ? $criterias->groupBy('segment') : collect();

        foreach ($participants as $item) {
            $part = [
                'participant_no' => $item->participant_no,
                'participant'    => $item->participant,
                'deduction'      => $item->higalaayDeduction($category->category)?->deduction ?? 0,
                'judge_scores'   => [],
                'subtotals'      => [],
                'grand'          => 0,
            ];

            $totalRankScore = 0;
            $totalScore     = 0;
            foreach ($judges as $judge) {
                $ranked = $item->getRankingsByJudge($judge->user_id, $category->category, $item->id);

                if ($isWeighted) {
                    $weightedScore = 0;
                    foreach ($segmentedCriterias as $segCriterias) {
                        $segWeight = $segCriterias->first()->segment_weight;
                        $segMax    = $segCriterias->sum('perfect_score');
                        if ($segMax == 0) continue;
                        $segRaw = 0;
                        foreach ($segCriterias as $criteria) {
                            $segRaw += $item->getHigalaayScoreByJudge($judge->id, $category->category, $criteria);
                        }
                        $weightedScore += ($segRaw / $segMax) * $segWeight;
                    }
                    $subtotal = round($weightedScore, 4);
                } else {
                    $subtotal = $item->getHigalaayScoreByJudge($judge->id, $category->category);
                }

                $part['judge_scores'][$judge->user_id] = $ranked ?: 0;
                $part['subtotals'][$judge->user_id]    = $subtotal;

                if ($ranked) $totalRankScore += $ranked;
                if ($subtotal) $totalScore += $subtotal;
            }
            $part['totalScore'] = $judges->count() > 0 ? $totalScore / $judges->count() : 0;
            $part['grand']      = $totalRankScore;
            $grands[] = $part;
        }

        // Sort by grand total (Ascending - lowest first)
        usort($grands, function ($a, $b) {
            if ($a['grand'] == 0 && $b['grand'] != 0) return 1;
            if ($b['grand'] == 0 && $a['grand'] != 0) return -1;
            return $a['grand'] <=> $b['grand']; // Ascending order
        });

        // Assign ranks
        return $this->assignRanks($grands);
    }


    private function assignRanks($grands)
    {
        $rank = 1;
        $previousScore = null;
        $sameRankCount = 0;

        foreach ($grands as &$participantData) {
            if ($previousScore === null) {
                // First participant
                $participantData['ordinal_rank'] = $rank;
            } else {
                if ($participantData['grand'] == $previousScore) {
                    // Same score, same rank
                    $participantData['ordinal_rank'] = $rank;
                    $sameRankCount++;
                } else {
                    // Different score, increment rank
                    $rank += 1 + $sameRankCount;
                    $participantData['ordinal_rank'] = $rank;
                    $sameRankCount = 0;
                }
            }

            $previousScore = $participantData['grand'];
        }

        return $grands;
    }
}
