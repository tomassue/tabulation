<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;

class ReportHeader extends Component
{
    use WithFileUploads;

    // Text fields
    public $headerTitle;
    public $headerVenue;
    public $headerTime;
    public $headerVenueAlt;
    public $headerTimeAlt;

    // Image upload fields (new uploads)
    public $logoLeft1Upload;
    public $logoLeft2Upload;
    public $logoRight1Upload;
    public $logoRight2Upload;
    public $watermarkUpload;
    public $footerUpload;

    // Current saved filenames
    public $logoLeft1;
    public $logoLeft2;
    public $logoRight1;
    public $logoRight2;
    public $watermark;
    public $footer;

    public function mount()
    {
        $this->headerTitle    = Setting::get('report_header_title', '');
        $this->headerVenue    = Setting::get('report_header_venue', '');
        $this->headerTime     = Setting::get('report_header_time', '');
        $this->headerVenueAlt = Setting::get('report_header_venue_alt', '');
        $this->headerTimeAlt  = Setting::get('report_header_time_alt', '');
        $this->logoLeft1  = Setting::get('report_logo_left_1');
        $this->logoLeft2  = Setting::get('report_logo_left_2');
        $this->logoRight1 = Setting::get('report_logo_right');
        $this->logoRight2 = Setting::get('report_logo_right_2');
        $this->watermark  = Setting::get('report_watermark');
        $this->footer     = Setting::get('report_footer');
    }

    public function render()
    {
        return view('livewire.settings.report-header');
    }

    public function saveText()
    {
        $this->validate([
            'headerTitle'    => 'nullable|string|max:255',
            'headerVenue'    => 'nullable|string|max:255',
            'headerTime'     => 'nullable|string|max:100',
            'headerVenueAlt' => 'nullable|string|max:255',
            'headerTimeAlt'  => 'nullable|string|max:100',
        ]);

        Setting::set('report_header_title',     $this->headerTitle,    'Report header title prefix');
        Setting::set('report_header_venue',     $this->headerVenue,    'Report header default venue');
        Setting::set('report_header_time',      $this->headerTime,     'Report header default time');
        Setting::set('report_header_venue_alt', $this->headerVenueAlt, 'Report header alternate venue (e.g. bangga-sa-daygon)');
        Setting::set('report_header_time_alt',  $this->headerTimeAlt,  'Report header alternate time');

        session()->flash('textSaved', 'Text settings saved.');
    }

    public function saveImages()
    {
        $this->validate([
            'logoLeft1Upload'  => 'nullable|image|max:2048',
            'logoLeft2Upload'  => 'nullable|image|max:2048',
            'logoRight1Upload' => 'nullable|image|max:2048',
            'logoRight2Upload' => 'nullable|image|max:2048',
            'watermarkUpload'  => 'nullable|image|max:2048',
            'footerUpload'     => 'nullable|image|max:2048',
        ]);

        $uploads = [
            'logoLeft1Upload'  => 'report_logo_left_1',
            'logoLeft2Upload'  => 'report_logo_left_2',
            'logoRight1Upload' => 'report_logo_right',
            'logoRight2Upload' => 'report_logo_right_2',
            'watermarkUpload'  => 'report_watermark',
            'footerUpload'     => 'report_footer',
        ];

        $propMap = [
            'report_logo_left_1'  => 'logoLeft1',
            'report_logo_left_2'  => 'logoLeft2',
            'report_logo_right'   => 'logoRight1',
            'report_logo_right_2' => 'logoRight2',
            'report_watermark'    => 'watermark',
            'report_footer'       => 'footer',
        ];

        foreach ($uploads as $uploadProp => $settingKey) {
            if ($this->$uploadProp) {
                $path = $this->$uploadProp->store('report-header', 'public');
                Setting::set($settingKey, basename($path));
                $this->{$propMap[$settingKey]} = basename($path);
                $this->$uploadProp = null;
            }
        }

        session()->flash('imagesSaved', 'Images saved.');
    }

    public function removeImage(string $settingKey)
    {
        $propMap = [
            'report_logo_left_1'  => 'logoLeft1',
            'report_logo_left_2'  => 'logoLeft2',
            'report_logo_right'   => 'logoRight1',
            'report_logo_right_2' => 'logoRight2',
            'report_watermark'    => 'watermark',
            'report_footer'       => 'footer',
        ];

        $filename = Setting::get($settingKey);
        if ($filename) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete('report-header/' . $filename);
        }
        Setting::set($settingKey, null);
        if (isset($propMap[$settingKey])) {
            $this->{$propMap[$settingKey]} = null;
        }
    }
}
