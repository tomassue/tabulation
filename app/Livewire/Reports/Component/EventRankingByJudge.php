<?php

namespace App\Livewire\Reports\Component;

use App\Models\Category;
use App\Services\ReportService;
use Livewire\Component;
use Dompdf\Dompdf;
use Dompdf\Options;

class EventRankingByJudge extends Component
{
    public $selectedCategory, $percentage,  $base64pdf;
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
        $service = new ReportService($this->selectedCategory);
        $participants = $service->generateTopParticipants();
        $judges =  $service->judges;
        $percentage = $this->percentage;

        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $htmlContent = view('generated_pdf.judge-ranking-summary', compact('category', 'participants', 'judges', 'percentage'))->render();
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
}
