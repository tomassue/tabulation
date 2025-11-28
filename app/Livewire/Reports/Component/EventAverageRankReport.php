<?php

namespace App\Livewire\Reports\Component;

use Livewire\Component;
use App\Models\Category;
use App\Models\RefJudge;
use App\Models\RefParticipant;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Services\ReportService;

class EventAverageRankReport extends Component
{
    public $event1, $event2, $base64pdf;
    public function mount()
    {
        $this->event1 = null;
        $this->event2 = null;
    }
    public function render()
    {
        $categories = Category::where('is_active', 1)->get();
        return view('livewire.reports.component.event-average-rank-report', compact('categories'));
    }

    public function generateReport()
    {
        $this->validate([
            'event1' => 'required',
            'event2' => 'required',
        ]);

        $category1 = Category::find($this->event1);
        $category2 = Category::find($this->event2);
        $participants = RefParticipant::category($category1->category)->get();
        $judges =  RefJudge::category($category1->category)->get();

        $grands = $this->caculateRankings($participants, $category1, $category2);

        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $htmlContent = view('generated_pdf.multiple-rank-ranking-summary', compact('category1', 'category2', 'judges', 'grands'))->render();
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
        $this->dispatch('openAverageRankModal');
    }
    private function caculateRankings($participants, $category1, $category2)
    {
        $grands = [];

        foreach ($participants as $item) {

            //get the category1 and category2
            $cat1 = $item->averageHigalaay($category1->category);
            $cat2 = $item->averageHigalaay($category2->category);

            //get the participant
            $participant = $item->participant;

            //add to array
            array_push($grands, ['participant_no' => $item->participant_no, 'participant' => $participant, 'cat1' => $cat1, 'cat2' => $cat2]);
        }

        $grands = bong_rank_arranger($grands, 'cat1', 'cat1_ordinal_rank', false, "DESC");
        $grands = bong_rank_arranger($grands, 'cat2', 'cat2_ordinal_rank', false, "DESC");
        foreach ($grands as $index => &$participantData) {
            $grand = $participantData['cat1_ordinal_rank'] + $participantData['cat2_ordinal_rank'];
            $participantData['grand'] = $grand;
        }
        $grands = bong_rank_arranger($grands, 'grand', 'ordinal_rank', true, "ASC");

        return $grands;
    }
}
