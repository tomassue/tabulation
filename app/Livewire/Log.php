<?php

namespace App\Livewire;

use App\Models\Log as ModelsLog;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Log extends Component
{
    use WithPagination;

    public $user_id;
    public function render()
    {
        $logs = ModelsLog::where('user_id', 'LIKe', '%' . $this->user_id . '%')->paginate(10);
        $users = User::all();
        return view('livewire.log', compact('logs', 'users'));
    }
}
