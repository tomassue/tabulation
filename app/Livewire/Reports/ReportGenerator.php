<?php

namespace App\Livewire\Reports;

use App\Models\Category;
use App\Services\ReportService;
use Dompdf\Dompdf;
use Dompdf\Options;
use Livewire\Component;

class ReportGenerator extends Component
{
    public $selectedCategory, $selectedType, $reportType, $runnerups  = 0, $base64pdf;
    public function render()
    {
        $categories = Category::where('is_active', 1)->get();
        return view('livewire.reports.report-generator', compact('categories'));
    }
    public function generateReport()
    {
        $this->validate([
            'reportType' => 'required',
            'selectedCategory' => 'required',
        ]);
        $category = Category::where('category', $this->selectedCategory)->first();
        $service = new ReportService($this->selectedCategory);
        $participants = $service->generateTopParticipants();
        $judges =  $service->judges;
        $runnerups = $this->runnerups;
        $type = $this->selectedType;
        $reportType = $this->reportType;

        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $htmlContent = view('generated_pdf.higalaay-summary', compact('participants', 'judges', 'category', 'type', 'runnerups', 'reportType'))->render();
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($htmlContent);
        $dompdf->setPaper('A4', 'portrait');
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
}
