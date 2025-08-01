<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    public function render()
    {
        $data = [
            'users' => $this->getUsers(),
        ];

        return view('livewire.settings.user-management', $data);
    }

    public function getUsers()
    {
        $user = User::all();

        return $user;
    }
}
