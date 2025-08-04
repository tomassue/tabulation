<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    # Filter
    public $selectedStatus;
    public $editMode;

    #Properties
    public $user_id;
    public $name,
        $role,
        $email,
        $is_active;

    public function rules()
    {
        $rules = [
            'name' => 'required',
            'role' => 'required',
        ];

        return $rules;
    }

    public function updated($propertyName)
    {
        if ($propertyName == 'selectedStatus') {
            $this->resetPage();
        }
    }

    public function clear()
    {
        $this->reset();
    }

    public function addUser()
    {
        $this->dispatch('openModal');
    }

    public function editUser(User $user)
    {
        $this->editMode = true;
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->role = $user->role;
        $this->is_active = $user->is_active;

        $this->dispatch('openModal');
    }

    public function saveUser()
    {
        $this->validate();

        try {
            User::updateOrCreate(
                ['id' => $this->user_id],
                [
                    'name' => $this->name,
                    'email' => $this->name . '@example.com',
                    'role' => $this->role,
                    'is_active' => $this->is_active
                ]
            );

            $this->clear();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function render()
    {
        $data = [
            'users' => $this->getUsers(),
        ];

        return view('livewire.settings.user-management', $data);
    }

    public function getUsers()
    {
        $user = User::when($this->selectedStatus !== '' && $this->selectedStatus !== null, function ($query) {
            $query->where('is_active', $this->selectedStatus);
        })
            ->paginate(10);

        return $user;
    }
}
