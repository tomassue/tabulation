<?php

namespace App\Livewire\Reports\Component;

use App\Models\Category;
use App\Models\RefCriteria;
use App\Models\RefJudge;
use App\Models\RefParticipant;
use Livewire\Component;
use Dompdf\Dompdf;
use Dompdf\Options;

class EventReportByCriteria extends Component
{
    public $selectedCategory, $selectedCriteria, $base64pdf;

    public function render()
    {
        $categories = Category::where('is_active', 1)->get();
        $criterias  = RefCriteria::category($this->selectedCategory)->get();
        return view('livewire.reports.component.event-report-by-criteria', compact('categories', 'criterias'));
    }

    public function handleOptionChange()
    {
        $this->selectedCriteria = null;
    }

    public function generateReport()
    {
        $this->validate([
            'selectedCategory' => 'required',
            'selectedCriteria' => 'required',
        ]);

        $category     = Category::where('category', $this->selectedCategory)->first();
        $participants = RefParticipant::category($this->selectedCategory)->get();
        $judges       = RefJudge::category($this->selectedCategory)->get();
        $criteria     = RefCriteria::find($this->selectedCriteria);

        $grands = $this->calculateRankings($category, $participants, $judges, $criteria);

        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $htmlContent = view(
            'generated_pdf.criteria-ranking-summary',
            compact('category', 'judges', 'criteria', 'grands')
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
        $this->dispatch('openCriteriaByJudgeModal');
    }

    private function calculateRankings($category, $participants, $judges, $criteria)
    {
        $grands = [];

        foreach ($participants as $item) {
            $part = [
                'participant_no' => $item->participant_no,
                'participant'    => $item->participant,
                'judge_scores'   => [],
                'grand'          => 0,
            ];

            foreach ($judges as $judge) {
                $score = $item->getHigalaayScoreByJudge($judge->id, $category->category, $criteria);
                $part['judge_scores'][$judge->user_id] = $score ?: 0;
            }

            $judgeCount    = $judges->count();
            $part['grand'] = $judgeCount > 0
                ? round(array_sum($part['judge_scores']) / $judgeCount, 4)
                : 0;

            $grands[] = $part;
        }

        $grands = bong_rank_arranger($grands, 'grand', 'ordinal_rank', true, "DESC");
        return $grands;
    }
}
