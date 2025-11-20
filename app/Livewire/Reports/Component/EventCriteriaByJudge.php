<?php

namespace App\Livewire\Reports\Component;

use App\Models\Category;
use App\Models\RefCriteria;
use App\Models\RefJudge;
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
        $service = new ReportService($this->selectedCategory, null, $this->selectedJudge);
        $participants = $service->generateTopParticipants();

        $judge =  RefJudge::where('user_id', $this->selectedJudge)->first();
        $criterias = RefCriteria::category($this->selectedCategory)->get();

        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $htmlContent = view('generated_pdf.judge-criteria-summary', compact('category', 'participants', 'judge', 'criterias'))->render();
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
}
