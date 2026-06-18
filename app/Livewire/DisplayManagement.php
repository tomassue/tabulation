<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\LedManagement;
use App\Models\RefParticipant;
use Dompdf\Dompdf;
use Dompdf\Options;
use Livewire\Component;

class DisplayManagement extends Component
{
    public $category = '';
    public $show_first = false, $show_second = false, $show_third = false, $show_fourth = false, $show_all = false;
    public $first_id = '', $second_id = '', $third_id = '', $fourth_id = '';
    public $base64pdf = '';

    public function mount()
    {
        $led = LedManagement::query()->first();
        if ($led) {
            $this->category    = $led->category    ?? '';
            $this->show_first  = $led->show_first;
            $this->show_second = $led->show_second;
            $this->show_third  = $led->show_third;
            $this->show_fourth = $led->show_fourth ?? false;
            $this->show_all    = $led->show_all;
            $this->first_id    = $led->first_id    ?? '';
            $this->second_id   = $led->second_id   ?? '';
            $this->third_id    = $led->third_id    ?? '';
            $this->fourth_id   = $led->fourth_id   ?? '';
        }
    }

    public function render()
    {
        $led = LedManagement::query()->with(['firstParticipant', 'secondParticipant', 'thirdParticipant', 'fourthParticipant'])->first();
        $categories = Category::where('is_active', 1)->get();

        $participants = $this->category
            ? RefParticipant::query()->category($this->category)->orderBy('participant')->get()
            : collect();

        return view('livewire.display-management', compact('led', 'categories', 'participants'));
    }

    public function changeCategory()
    {
        $this->first_id  = '';
        $this->second_id = '';
        $this->third_id  = '';
        $this->fourth_id = '';

        $exist = LedManagement::query()->first();
        $data = [
            'category'    => $this->category,
            'show_first'  => 0,
            'show_second' => 0,
            'show_third'  => 0,
            'show_fourth' => 0,
            'show_all'    => 0,
            'first_id'    => null,
            'second_id'   => null,
            'third_id'    => null,
            'fourth_id'   => null,
        ];

        $exist ? $exist->update($data) : LedManagement::create($data);
    }

    public function savePlacements()
    {
        $led = LedManagement::query()->first();
        if (!$led) return;

        $led->update([
            'first_id'  => $this->first_id  ?: null,
            'second_id' => $this->second_id ?: null,
            'third_id'  => $this->third_id  ?: null,
            'fourth_id' => $this->fourth_id ?: null,
        ]);
    }

    public function changeFirst()
    {
        $led = LedManagement::query()->first();
        if (!$led) return;
        $led->update(['show_first' => !$led->show_first, 'show_second' => 0, 'show_third' => 0, 'show_fourth' => 0, 'show_all' => 0]);
        $this->syncFlags($led->fresh());
    }

    public function changeSecond()
    {
        $led = LedManagement::query()->first();
        if (!$led) return;
        $led->update(['show_second' => !$led->show_second, 'show_first' => 0, 'show_third' => 0, 'show_fourth' => 0, 'show_all' => 0]);
        $this->syncFlags($led->fresh());
    }

    public function changeThird()
    {
        $led = LedManagement::query()->first();
        if (!$led) return;
        $led->update(['show_third' => !$led->show_third, 'show_first' => 0, 'show_second' => 0, 'show_fourth' => 0, 'show_all' => 0]);
        $this->syncFlags($led->fresh());
    }

    public function changeFourth()
    {
        $led = LedManagement::query()->first();
        if (!$led) return;
        $led->update(['show_fourth' => !$led->show_fourth, 'show_first' => 0, 'show_second' => 0, 'show_third' => 0, 'show_all' => 0]);
        $this->syncFlags($led->fresh());
    }

    public function changeAll()
    {
        $led = LedManagement::query()->first();
        if (!$led) return;
        $led->update(['show_all' => !$led->show_all, 'show_first' => 0, 'show_second' => 0, 'show_third' => 0, 'show_fourth' => 0]);
        $this->syncFlags($led->fresh());
    }

    public function hideAll()
    {
        $led = LedManagement::query()->first();
        if (!$led) return;
        $led->update(['show_all' => 0, 'show_first' => 0, 'show_second' => 0, 'show_third' => 0, 'show_fourth' => 0]);
        $this->syncFlags($led->fresh());
    }

    public function generateMcReport()
    {
        $led = LedManagement::with(['firstParticipant', 'secondParticipant', 'thirdParticipant', 'fourthParticipant'])->first();
        if (!$led) return;

        $categoryDesc = Category::where('category', $led->category)->value('description') ?? $led->category;

        $winners = collect([
            ['rank' => 4, 'label' => '4TH PLACE', 'participant' => $led->fourthParticipant],
            ['rank' => 3, 'label' => '3RD PLACE', 'participant' => $led->thirdParticipant],
            ['rank' => 2, 'label' => '2ND PLACE', 'participant' => $led->secondParticipant],
            ['rank' => 1, 'label' => 'CHAMPION', 'participant' => $led->firstParticipant],
        ])->filter(fn($w) => $w['participant'] !== null);

        $htmlContent = view('generated_pdf.mc-script', compact('categoryDesc', 'winners'))->render();

        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($htmlContent);
        $dompdf->setPaper('folio', 'portrait');
        $dompdf->render();

        $this->base64pdf = base64_encode($dompdf->output());
        $this->dispatch('openMcReportModal');
    }

    private function syncFlags($led): void
    {
        $this->show_first  = (bool) $led->show_first;
        $this->show_second = (bool) $led->show_second;
        $this->show_third  = (bool) $led->show_third;
        $this->show_fourth = (bool) ($led->show_fourth ?? false);
        $this->show_all    = (bool) $led->show_all;
    }
}
