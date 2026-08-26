<?php

namespace App\Livewire\Reference;

use App\Models\Category;
use Livewire\Component;
use App\Models\RefJudge;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class Judges extends Component
{
    use WithPagination;
    public $id, $judge, $nickname, $selectedCategories = [], $selectedCateg, $password;
    public $is_active = 1, $selectedStatus;
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['selectedCateg', 'selectedStatus'])) {
            $this->resetPage();
        }
    }
    public function render()
    {
        $judges = RefJudge::when($this->selectedCateg, function ($query) {
            $query->whereJsonContains('category', $this->selectedCateg);
        })->when($this->selectedStatus !== '' && $this->selectedStatus !== null, function ($query) {
            $query->where('is_active', $this->selectedStatus);
        })->orderBy('id', 'desc')->paginate(10);
        $categories = Category::where('is_active', 1)->get();
        return view('livewire.reference.judges', compact('judges', 'categories'));
    }
    public function addJudge()
    {
        $this->reset();
        $this->is_active = 1;
        $this->dispatch('openModal');
    }
    public function editJudge($id)
    {
        $this->id = $id;
        $judge = RefJudge::find($id);

        $this->judge = $judge->judge;
        $this->nickname = $judge->nickname;
        $this->selectedCategories = $judge->category;
        $this->is_active = $judge->is_active;
        $this->dispatch('openModal');
    }
    public function toggleStatus($id)
    {
        $judge = RefJudge::find($id);
        if (!$judge) {
            return session()->flash('error', 'Judge not found!');
        }

        DB::transaction(function () use ($judge) {
            $judge->is_active = $judge->is_active ? 0 : 1;
            $judge->save();

            $user = User::find($judge->user_id);
            if ($user) {
                $user->is_active = $judge->is_active;
                $user->save();
            }
        });

        return session()->flash('status', 'Sucessfully updated status!');
    }
    public function saveJudge()
    {
        $this->validate([
            'judge' => 'required',
            'nickname' => 'required',
            'selectedCategories' => 'array',
            'selectedCategories.*' => 'exists:categories,category',
            'is_active' => 'required|boolean',
        ]);

        DB::transaction(function () {

            $judge = RefJudge::findOrNew($this->id);
            $user =  User::findOrNew($judge->user_id);

            $user->name  = $this->judge;
            $user->email = $this->generateEmailFromName($this->judge);
            $user->role = 'user';
            $user->password = Hash::make('password');
            $user->is_active = (int) $this->is_active;
            $user->save();

            $judge->judge = $this->judge;
            $judge->nickname = $this->nickname;
            $judge->category = $this->selectedCategories;
            $judge->user_id = $user->id;
            $judge->is_active = (int) $this->is_active;
            $judge->save();

            return session()->flash('status', 'Sucessfully saved!');
        });
    }
    private static function generateEmailFromName(string $name, string $domain = 'tabulation.com'): string
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
    public function deleteJudge($id)
    {
        $this->resetValidation();
        $this->id = $id;
        $this->dispatch('openDeleteModal');
    }
    public function executeDelete()
    {
        $this->validate([
            'password' => 'required|current_password',
        ]);

        $judge = RefJudge::find($this->id);
        if ($judge) {
            User::find($judge->user_id)->delete();
            $judge->delete();
            $this->password = null;
            return session()->flash("status", "Sucessfully deleted!");
        }
        return session()->flash("error", "Failed to delete");
    }
}
