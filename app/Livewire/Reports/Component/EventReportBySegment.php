<?php

namespace App\Livewire\Reports\Component;

use App\Models\Category;
use App\Models\RefCriteria;
use App\Models\RefJudge;
use App\Models\RefParticipant;
use Livewire\Component;
use Dompdf\Dompdf;
use Dompdf\Options;

class EventReportBySegment extends Component
{
    public $selectedCategory, $selectedSegment, $base64pdf;

    public function render()
    {
        $categories = Category::where('is_active', 1)->get();
        $segments = collect();
        if ($this->selectedCategory) {
            $segments = RefCriteria::category($this->selectedCategory)
                ->whereNotNull('segment')
                ->whereNotNull('segment_weight')
                ->select('segment', 'segment_weight')
                ->distinct()
                ->get();
        }
        return view('livewire.reports.component.event-report-by-segment', compact('categories', 'segments'));
    }

    public function handleOptionChange()
    {
        $this->selectedSegment = null;
    }

    public function generateReport()
    {
        $this->validate([
            'selectedCategory' => 'required',
            'selectedSegment'  => 'required',
        ]);

        $category     = Category::where('category', $this->selectedCategory)->first();
        $participants = RefParticipant::category($this->selectedCategory)->get();
        $judges       = RefJudge::active()->category($this->selectedCategory)->get();
        $segCriterias = RefCriteria::category($this->selectedCategory)
            ->where('segment', $this->selectedSegment)
            ->get();

        if ($segCriterias->isEmpty()) {
            $this->addError('selectedSegment', 'No criteria found for this segment.');
            return;
        }

        $segmentName = $this->selectedSegment;
        $segWeight   = $segCriterias->first()->segment_weight;
        $segMax      = $segCriterias->sum('perfect_score');

        $grands = $this->calculateRankings($category, $participants, $judges, $segCriterias, $segWeight, $segMax);

        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $htmlContent = view(
            'generated_pdf.segment-ranking-summary',
            compact('category', 'judges', 'segCriterias', 'segmentName', 'segWeight', 'segMax', 'grands')
        )->render();

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($htmlContent);
        $dompdf->setPaper('folio', 'landscape');
        $dompdf->render();

        $canvas      = $dompdf->getCanvas();
        $fontMetrics = $dompdf->getFontMetrics();
        $font        = $fontMetrics->getFont("Arial", "normal");
        $canvas->page_text(850, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 10, [0, 0, 0]);

        $this->base64pdf = base64_encode($dompdf->output());
        $this->dispatch('openSegmentModal');
    }

    private function calculateRankings($category, $participants, $judges, $segCriterias, $segWeight, $segMax)
    {
        $grands = [];

        // Step 1: compute each participant's weighted segment score per judge
        foreach ($participants as $item) {
            $part = [
                'participant_no' => $item->participant_no,
                'participant'    => $item->participant,
                'judge_scores'   => [],   // rank number per judge (filled in step 2)
                'subtotals'      => [],   // weighted score per judge
                'grand'          => 0,    // sum of rank numbers (lower = better)
            ];

            foreach ($judges as $judge) {
                $segRaw = 0;
                foreach ($segCriterias as $criteria) {
                    $segRaw += $item->getHigalaayScoreByJudge($judge->id, $category->category, $criteria);
                }
                $weightedScore = $segMax > 0 ? ($segRaw / $segMax) * $segWeight : 0;
                $part['subtotals'][$judge->user_id] = round($weightedScore, 4);
            }

            $grands[] = $part;
        }

        // Step 2: for each judge, rank participants by their weighted score (DESC) and store rank number
        foreach ($judges as $judge) {
            // Sort a copy by this judge's subtotal DESC
            $judgeScores = array_map(fn($p) => [
                'participant_no' => $p['participant_no'],
                'score'          => $p['subtotals'][$judge->user_id],
            ], $grands);

            usort($judgeScores, fn($a, $b) => $b['score'] <=> $a['score']);

            // Assign ranks with tie handling (same score = same rank)
            $rank          = 1;
            $prevScore     = null;
            $tieCount      = 0;
            $rankMap       = [];

            foreach ($judgeScores as $entry) {
                if ($prevScore === null) {
                    $rankMap[$entry['participant_no']] = $rank;
                } elseif ($entry['score'] == $prevScore) {
                    $rankMap[$entry['participant_no']] = $rank;
                    $tieCount++;
                } else {
                    $rank += 1 + $tieCount;
                    $rankMap[$entry['participant_no']] = $rank;
                    $tieCount = 0;
                }
                $prevScore = $entry['score'];
            }

            // Write rank numbers back into $grands
            foreach ($grands as &$part) {
                $part['judge_scores'][$judge->user_id] = $rankMap[$part['participant_no']] ?? 0;
            }
            unset($part);
        }

        // Step 3: sum rank numbers → grand total (lower is better)
        foreach ($grands as &$part) {
            $totalRank = 0;
            foreach ($judges as $judge) {
                $totalRank += $part['judge_scores'][$judge->user_id];
            }
            $part['grand'] = $totalRank;
        }
        unset($part);

        // Step 4: sort ascending (lowest rank sum = winner), handle zeros last
        usort($grands, function ($a, $b) {
            if ($a['grand'] == 0 && $b['grand'] != 0) return 1;
            if ($b['grand'] == 0 && $a['grand'] != 0) return -1;
            return $a['grand'] <=> $b['grand'];
        });

        return $this->assignRanks($grands);
    }

    private function assignRanks($grands)
    {
        $rank          = 1;
        $previousScore = null;
        $sameRankCount = 0;

        foreach ($grands as &$part) {
            if ($previousScore === null) {
                $part['ordinal_rank'] = $rank;
            } elseif ($part['grand'] == $previousScore) {
                $part['ordinal_rank'] = $rank;
                $sameRankCount++;
            } else {
                $rank += 1 + $sameRankCount;
                $part['ordinal_rank'] = $rank;
                $sameRankCount = 0;
            }
            $previousScore = $part['grand'];
        }
        unset($part);

        return $grands;
    }
}
