<?php

namespace App\Livewire\Reference;

use App\Models\Category;
use Livewire\Component;
use App\Models\RefJudge;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Judges extends Component
{
    public $id, $judge, $nickname, $selectedCategories = [], $selectedCateg, $password;
    public function render()
    {
        $judges = RefJudge::all();
        if ($this->selectedCateg) {
            $judges = RefJudge::whereJsonContains('category', $this->selectedCateg)->get();
        }
        $categories = Category::where('is_active', 1)->get();
        return view('livewire.reference.judges', compact('judges', 'categories'));
    }
    public function addJudge()
    {
        $this->reset();
        $this->dispatch('openModal');
    }
    public function editJudge($id)
    {
        $this->id = $id;
        $judge = RefJudge::find($id);

        $this->judge = $judge->judge;
        $this->nickname = $judge->nickname;
        $this->selectedCategories = $judge->category;
        $this->dispatch('openModal');
    }
    public function saveJudge()
    {
        $this->validate([
            'judge' => 'required',
            'nickname' => 'required',
            'selectedCategories' => 'array',
            'selectedCategories.*' => 'exists:categories,category',
        ]);

        DB::transaction(function () {

            $judge = RefJudge::findOrNew($this->id);
            $user =  User::findOrNew($judge->user_id);

            $user->name  = $this->judge;
            $user->email = $this->generateEmailFromName($this->judge);
            $user->role = 'user';
            $user->password = Hash::make('password');
            $user->save();

            $judge->judge = $this->judge;
            $judge->nickname = $this->nickname;
            $judge->category = $this->selectedCategories;
            $judge->user_id = $user->id;
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
