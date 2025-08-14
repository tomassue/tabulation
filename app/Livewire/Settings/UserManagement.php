<?php

namespace App\Livewire\Settings;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
        $is_active,
        $password,
        $old_password,
        $password_confirmation;

    public function rules()
    {
        $rules = [
            'name' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
        ];

        return $rules;
    }

    public function updated($propertyName)
    {
        if ($propertyName == 'selectedStatus') {
            $this->resetPage();
        }
        if ($propertyName == 'name') {
            $this->email = $this->generateEmailFromName($this->name);
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
        $this->email = $user->email;
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
                    'email' => $this->email ?? $this->generateEmailFromName($this->name),
                    'role' => $this->role,
                    'is_active' => $this->is_active,
                    'password' => Hash::make('password'),
                ]
            );

            return session()->flash('status', 'Sucessfully saved!');
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

    public function getCategories()
    {
        $categories = Category::where('is_active', 1)->get();

        return $categories;
    }

    public function resetOpen($id)
    {
        $this->user_id = $id;
        $this->dispatch('openResetModal');
    }
    public function savePassword()
    {
        $user = User::find($this->user_id);
        if (!$user) {
            return session()->flash('status', 'User not found!');
        }
        $this->validate([
            'old_password' => 'required|current_password',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        if (!Hash::check($this->old_password, $user->password)) {
            return session()->flash('status', 'Old password is incorrect!');
        }

        $user->password = $this->password;
        $user->save();

        return session()->flash('status', 'Sucessfully reset!');
    }
    private static function generateEmailFromName(string $name, string $domain = 'example.com'): string
    {
        // Convert name to lowercase
        $email = strtolower($name);

        // Replace spaces with dots
        $email = str_replace(' ', '.', $email);

        // Remove any characters that are not alphanumeric or dots
        $email = preg_replace('/[^a-z0-9.]/', '', $email);

        // Ensure no multiple dots
        $email = preg_replace('/\.\.+/', '.', $email);

        // Trim leading/trailing dots
        $email = trim($email, '.');

        // Append the domain
        return $email . '@' . $domain;
    }
}
