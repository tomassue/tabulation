<?php

namespace App\Livewire\Reports\Component;

use Livewire\Component;
use App\Models\Category;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Services\ReportService;

class EventAverageReport extends Component
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
        return view('livewire.reports.component.event-average-report', compact('categories'));
    }
    public function generateReport()
    {
        $this->validate([
            'event1' => 'required',
            'event2' => 'required',
        ]);

        $category1 = Category::find($this->event1);
        $category2 = Category::find($this->event2);
        $service = new ReportService($category1->category);
        $participants = $service->generateTopParticipants();
        $judges =  $service->judges;

        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $htmlContent = view('generated_pdf.multiple-summary', compact('category1', 'category2', 'judges'))->render();
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
        $this->dispatch('openAverageModal');
    }
}
