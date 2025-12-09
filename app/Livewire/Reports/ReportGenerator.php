<?php

namespace App\Livewire\Reports;

use App\Models\Category;
use App\Models\RefCriteria;
use App\Models\RefJudge;
use App\Models\RefParticipant;
use App\Services\ReportService;
use Dompdf\Dompdf;
use Dompdf\Options;
use Livewire\Component;

class ReportGenerator extends Component
{
    public $categories, $selectedCategory, $selectedCategory2, $selectedCriteria, $selectedCriteria2, $selectedType, $reportType, $runnerups  = 0, $base64pdf, $selectedReports, $selectedScoring;
    public function mount()
    {
        $this->categories = Category::where('is_active', 1)->get();
    }
    public function render()
    {
        $criterias1 = RefCriteria::where('category', $this->selectedCategory)->whereIn("criteria", ['Sound'])->get();
        $criterias2 = RefCriteria::where('category', $this->selectedCategory2)->whereIn("criteria", ['Sound'])->get();
        return view('livewire.reports.report-generator', compact('criterias1', 'criterias2'));
    }
    public function handleOptionChange()
    {
        $this->selectedCriteria = null;
    }
    public function handleOptionChange2()
    {
        $this->selectedCriteria2 = null;
    }
    public function generateReport()
    {
        $this->validate([
            'selectedCriteria' => 'required',
            'selectedCriteria2' => 'required',
            'selectedCategory' => 'required',
            'selectedCategory2' => 'required',
        ]);
        $category1 = Category::where('category', $this->selectedCategory)->first();
        $category2 = Category::where('category', $this->selectedCategory2)->first();

        $participants = RefParticipant::category($this->selectedCategory)->get();
        $judges =  RefJudge::category($this->selectedCategory)->get();

        $criteria1 = RefCriteria::find($this->selectedCriteria);
        $criteria2 = RefCriteria::find($this->selectedCriteria2);

        $grands = $this->caculateRankings($participants, $category1, $category2, $criteria1, $criteria2);

        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $htmlContent = view('generated_pdf.higalaay-summary', compact('judges', 'category1', 'category2', 'criteria1', 'grands'))->render();
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
        $this->dispatch('openModal');
    }

    private function caculateRankings($participants, $category1, $category2,  $criteria, $criteria2)
    {
        $grands = [];
        // dd($category->category);
        foreach ($participants as $item) {
            $cat1 =  $item->averageHigalaay($category1?->category, $criteria)  * 0.5;
            $cat2 =  $item->averageHigalaay($category2?->category, $criteria2)  * 0.5;

            $grand = $cat1 + $cat2;

            $part = [
                'participant_no' => $item->participant_no,
                'participant' => $item->participant,
                'cat1' => $cat1,
                'cat2' => $cat2,
                'grand' =>  $grand,
            ];

            $grands[] = $part;
        }
        $grands = bong_rank_arranger($grands, 'grand', 'ordinal_rank', true, "DESC");

        return $grands;
    }
}
