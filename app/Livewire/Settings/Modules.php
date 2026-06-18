<?php

namespace App\Livewire\Settings;

use App\Models\Category;
use App\Models\Setting;
use App\Models\RefCriteria;
use App\Models\RefParticipant;
use App\Models\RefJudge;
use Dompdf\Dompdf;
use Dompdf\Options;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use function Laravel\Prompts\error;

class Modules extends Component
{
    use WithPagination;
    # Filter
    public $selectedStatus;
    public $search;

    # Properties
    public $category_id;
    public $category,
        $description,
        $display_participant,
        $is_active,
        $winners,
        $tabulation_mode = 'average';

    # Score sheet PDF preview
    public $base64pdf;

    public function rules()
    {
        return [
            'category' => 'required',
            'description' => 'required',
            'winners' => 'required',
            'is_active' => 'required',
            'display_participant' => 'required',
        ];
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['selectedStatus', 'search'])) {
            $this->resetPage();
        }
    }

    public function clear()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function addModule()
    {
        $this->dispatch('openModal');
    }

    public function render()
    {
        $data = [
            'modules' => $this->getModules(),
        ];

        return view('livewire.settings.modules', $data);
    }

    public function getModules()
    {
        $modules = Category::when($this->selectedStatus !== '' && $this->selectedStatus !== null, function ($query) {
            $query->where('is_active', $this->selectedStatus);
        })->when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->where('category', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        })
            ->orderBy('id', 'desc')->paginate(5);

        return $modules;
    }

    public function saveModule()
    {
        $this->validate();

        try {
            Category::updateOrCreate(
                ['id' => $this->category_id],
                [
                    'category' => Str::slug($this->category),
                    'description' => $this->description,
                    'winners' => $this->winners,
                    'is_active' => $this->is_active,
                    'display_participant' => $this->display_participant,
                    'tabulation_mode' => $this->tabulation_mode,
                    'icon' => '<i class="bi bi-box-seam"></i>'
                ]
            );
        } catch (\Throwable $th) {
            //throw $th;
            return error($th->getMessage());
        }
    }

    public function editModule($id)
    {
        $module = Category::findOrFail($id);
        $this->category_id = $module->id;
        $this->category = $module->category;
        $this->description = $module->description;
        $this->winners = $module->winners;
        $this->is_active = $module->is_active;
        $this->display_participant = $module->display_participant;
        $this->tabulation_mode = $module->tabulation_mode ?? 'average';

        $this->dispatch('openModal');
    }

    public function deactivateModule($id)
    {
        Category::where('id', $id)->update(['is_active' => 0]);
    }

    public function activateModule($id)
    {
        Category::where('id', $id)->update(['is_active' => 1]);
    }

    public function generateScoreSheet($id)
    {
        $module = Category::findOrFail($id);
        $slug = $module->category;

        $criterias    = RefCriteria::where('category', $slug)->get();
        $participants = RefParticipant::category($slug)->orderBy('participant_no')->get();
        $judges       = RefJudge::category($slug)->get();

        $options = new Options();
        $options->set('isRemoteEnabled', false);

        $html = view('generated_pdf.blank-scoresheet', [
            'category'     => $module,
            'categoryName' => $module->description,
            'criterias'    => $criterias,
            'participants' => $participants,
            'judges'       => $judges,
        ])->render();

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', 'landscape');
        $dompdf->render();

        $this->base64pdf = base64_encode($dompdf->output());
        $this->dispatch('openScoreSheetModal');
    }

    public function toggleLock($id)
    {
        $category = Category::findOrFail($id);
        $key = 'scoring_locked_' . $category->category;
        $current = Setting::get($key, false);
        Setting::set($key, !$current, 'Scoring lock for ' . $category->description);
    }
}
