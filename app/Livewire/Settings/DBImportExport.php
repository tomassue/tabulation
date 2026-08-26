<?php

namespace App\Livewire\Settings;

use App\Exports\HigalaayExport;
use App\Imports\HigalaayImport;
use App\Models\Category;
use App\Models\Higalaay as ModelsHigalaay;
use App\Models\HigalaayDeduction;
use App\Models\RefJudge;
use App\Models\TechnicalScore;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class DBImportExport extends Component
{
    use WithFileUploads;
    public $category_name, $judge_id, $excel_file, $count, $email, $password;
    public $api_url = 'https://services.cagayandeoro.gov.ph:8087/tabulation/api/tab-v1';

    public function mount()
    {
        $this->api_url = \App\Models\Setting::get('api_url', $this->api_url);
    }

    public function saveApiUrl()
    {
        $this->validate(['api_url' => 'required|url']);
        \App\Models\Setting::set('api_url', rtrim($this->api_url, '/'), 'API endpoint URL');
        session()->flash('status', 'API URL saved successfully.');
    }
    public function render()
    {
        $categories = Category::where('is_active', 1)->get();
        $judges = RefJudge::whereJsonContains('category', $this->category_name)->get();
        return view('livewire.settings.db-import-export', compact('judges', 'categories'));
    }
    public function updatedJudge()
    {
        $this->count = ModelsHigalaay::where('category', $this->category_name)->where('judge_id', $this->judge_id)->count();
    }
    public function exportDatabase()
    {
        $this->validate([
            'category_name' => 'required',
            'judge_id' => 'required',
        ]);
        return Excel::download(new HigalaayExport($this->category_name, $this->judge_id), 'higalaay.xlsx');
    }
    public function importDatabase()
    {
        $this->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv',
        ]);
        Excel::import(new HigalaayImport($this->category_name, $this->judge_id),  $this->excel_file);
        session()->flash('message', 'File imported successfully!');
        $this->excel_file = null; // Clear the file input
    }
    public function login()
    {
        $data = $this->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $login = Http::post($this->api_url . '/login', $data);
        if ($login->failed()) {
            // Handle login failure
            return session()->flash('error', $login->json()['message']);
        } else {
            session()->put('token', $login->json()['access_token']);
            return session()->flash('message', 'Login successful!');
        }
    }
    public function logout()
    {
        session()->forget('token');
    }
    public function getReference()
    {


        $token = session('token');

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-Custom-Header' => 'MyValue',
        ])->withToken($token)->get($this->api_url . '/get-reference');

        if ($response->successful()) {
            $message = '';
            $body = $response->json();
            if (isset($body['judges'])) {
                $judges = $body['judges'];
                $result = DB::table('ref_judges')->insertOrIgnore($judges);
                $message .= 'Judges: ' . $result . '<br>';
            }
            if (isset($body['participants'])) {
                $participants = $body['participants'];
                $result = DB::table('ref_participants')->insertOrIgnore($participants);
                $message .= 'Participants: ' . $result . '<br>';
            }
            if (isset($body['categories'])) {
                $categories = $body['categories'];
                $result = DB::table('categories')->insertOrIgnore($categories);
                $message .= 'Categories: ' . $result . '<br>';
            }
            if (isset($body['criteria'])) {
                $criteria = $body['criteria'];
                $result = DB::table('ref_criterias')->insertOrIgnore($criteria);
                $message .= 'Criteria: ' . $result . '<br>';
            }
            if (isset($body['deductions'])) {
                $deductions = $body['deductions'];
                $result = DB::table('ref_deductions')->insertOrIgnore($deductions);
                $message .= 'Deductions: ' . $result . '<br>';
            }
            if (isset($body['technical_categories'])) {
                $technical_categories = $body['technical_categories'];
                $result = DB::table('technical_categories')->insertOrIgnore($technical_categories);
                $message .= 'Technical Categories: ' . $result . '<br>';
            }
            if (isset($body['technical_deductions'])) {
                $technical_deductions = $body['technical_deductions'];
                $result = DB::table('technical_deductions')->insertOrIgnore($technical_deductions);
                $message .= 'Technical Deductions: ' . $result . '<br>';
            }
            if (isset($body['technical_judge_assignments'])) {
                $technical_judge_assignments = $body['technical_judge_assignments'];
                $result = DB::table('technical_judge_assignments')->insertOrIgnore($technical_judge_assignments);
                $message .= 'Technical Judge Assignments: ' . $result . '<br>';
            }
            if (isset($body['technical_sub_criterias'])) {
                $technical_sub_criterias = $body['technical_sub_criterias'];
                $result = DB::table('technical_sub_criterias')->insertOrIgnore($technical_sub_criterias);
                $message .= 'Technical Sub-Criteria: ' . $result . '<br>';
            }
            if (isset($body['users'])) {
                $users = $body['users'];
                $result = DB::table('users')->insertOrIgnore($users);
                $message .= 'Users: ' . $result . '<br>';
            }
            if (isset($body['settings'])) {
                $settingsCount = 0;
                foreach ($body['settings'] as $setting) {
                    \App\Models\Setting::updateOrCreate(
                        ['name' => $setting['name']],
                        ['value' => $setting['value'], 'description' => $setting['description'] ?? null]
                    );
                    $settingsCount++;
                }
                $message .= 'Settings: ' . $settingsCount . '<br>';
            }
            if (isset($body['logos'])) {
                $logosCount = 0;
                foreach ($body['logos'] as $logo) {
                    Storage::disk('public')->put('report-header/' . $logo['filename'], base64_decode($logo['content']));
                    $logosCount++;
                }
                $message .= 'Logos: ' . $logosCount . '<br>';
            }
            return session()->flash('status', $message);
            // Request was successful (2xx status code)
        } elseif ($response->clientError()) {
            // Client error (4xx status code)
            return session()->flash('error', 'Client error:' . $response->body());
        } elseif ($response->serverError()) {
            // Server error (5xx status code)
            return session()->flash('error', 'Server error:' . $response->body());
        }
    }
    public function uploadDatabase()
    {

        $token = session('token');

        $data = ModelsHigalaay::get();
        $deductions = HigalaayDeduction::get();
        $technical_scores = TechnicalScore::get();

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-Custom-Header' => 'MyValue',
        ])->withToken($token)->post(
            $this->api_url . '/upload-database',
            [
                'higalaay' => $data,
                'deductions' => $deductions,
                'technical_scores' => $technical_scores
            ]
        );
        if ($response->successful()) {
            // Request was successful (2xx status code)
            return session()->flash('status', 'Data has been saved successfully:' . $response->json()['message']);
        } elseif ($response->clientError()) {
            // Client error (4xx status code)
            return session()->flash('error', 'Client error:' . $response->json()['message']);
        } elseif ($response->serverError()) {
            // Server error (5xx status code)
            return session()->flash('error', 'Server error:' . $response->json()['message']);
        }
    }
    public function downloadDatabase()
    {
        $countData = 0;
        $countDeductions = 0;
        $token = session('token');
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-Custom-Header' => 'MyValue',
        ])->withToken($token)->get($this->api_url . '/download-database');
        if ($response->successful()) {
            $body = $response->json();
            if (isset($body['higalaays'])) {
                $higalaays = $body['higalaays'];
                foreach ($higalaays as  $value) {
                    $countData += ModelsHigalaay::updateOrCreate(
                        [
                            'participant_id' => $value['participant_id'],
                            'criteria_id' => $value['criteria_id'],
                            'judge_id' => $value['judge_id'],
                            'category' => $value['category'],
                        ],
                        $value
                    )->wasChanged() ? 1 : 0;
                }
            }
            if (isset($body['higalaay_deductions'])) {
                $higalaay_deductions = $body['higalaay_deductions'];
                foreach ($higalaay_deductions as $value) {
                    $countDeductions += HigalaayDeduction::updateOrCreate(
                        [
                            'participant_id' => $value['participant_id'],
                            'category' => $value['category'],
                        ],
                        $value
                    )->wasChanged() ? 1 : 0;
                }
            }
            // Request was successful (2xx status code)
            return session()->flash('status', 'Data Affected: ' . $countData . ', Deductions Affected: ' . $countDeductions);
        } elseif ($response->clientError()) {
            // Client error (4xx status code)
            return session()->flash('error', 'Client error:' . $response->json()['message']);
        } elseif ($response->serverError()) {
            // Server error (5xx status code)
            return session()->flash('error', 'Server error:' . $response->json()['message']);
        }
    }
}
