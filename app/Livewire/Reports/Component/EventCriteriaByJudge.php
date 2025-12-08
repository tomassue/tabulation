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

class EventCriteriaByJudge extends Component
{
    public $selectedCategory, $selectedJudge,  $base64pdf;
    public function render()
    {
        $categories = Category::where('is_active', 1)->get();
        $judges = RefJudge::category($this->selectedCategory)->get();
        return view('livewire.reports.component.event-criteria-by-judge', compact('categories', 'judges'));
    }
    public function generateReport()
    {
        $this->validate([
            'selectedCategory' => 'required',
            'selectedJudge' => 'required',
        ]);

        $category = Category::where('category', $this->selectedCategory)->first();
        $participants = RefParticipant::category($this->selectedCategory)->get();
        $judge =  RefJudge::where('user_id', $this->selectedJudge)->first();
        $criterias = RefCriteria::category($this->selectedCategory)->get();

        $grands = $this->caculateRankings($category, $participants, $criterias, $judge);

        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $htmlContent = view('generated_pdf.judge-criteria-summary', compact('category', 'participants', 'judge', 'criterias', 'grands'))->render();
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
        $this->dispatch('openCriteriaModal');
    }
    public function handleOptionChange()
    {
        $this->selectedJudge = "";
        // Perform other actions like updating a dependent dropdown's options
    }
    private function caculateRankings($category, $participants, $criterias, $judge)
    {
        $grands = [];

        foreach ($participants as $item) {

            $part = [
                'participant_no' => $item->participant_no,
                'participant' => $item->participant,
                'criteria_scores' => [],
                'grand' => 0
            ];
            $totalScore = 0;
            foreach ($criterias as $criteria) {
                $criteria_score = $item->getHigalaayScoreByJudge($judge->id, $category->category, $criteria);
                $part['criteria_scores'][$criteria->id] = $criteria_score;

                if ($criteria_score) {
                    $totalScore += $criteria_score;
                }
            }
            $part['grand'] =  $totalScore;
            $grands[] = $part;
        }
        $grands = bong_rank_arranger($grands, 'grand', 'ordinal_rank', false, "DESC");
        return $grands;
    }
}
