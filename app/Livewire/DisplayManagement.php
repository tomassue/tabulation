<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\LedManagement;
use Livewire\Component;

class DisplayManagement extends Component
{
    public $id, $category, $show_first = false, $show_second = false, $show_third = false, $show_all = false;
    public function render()
    {
        $led = LedManagement::first();
        if ($led) {

            $this->category = $led->category;
            $this->show_first = $led->show_first;
            $this->show_second = $led->show_second;
            $this->show_third = $led->show_third;
            $this->show_all = $led->show_all;
        }
        $categories = Category::where('is_active', 1)->get();
        return view('livewire.display-management', compact('led', 'categories'));
    }
    public function changeCategory()
    {
        $exist = LedManagement::first();
        if (!$exist) {
            LedManagement::create([
                'show_first' => 0,
                'show_second' =>  0,
                'show_third' => 0,
                'show_all' =>   0,
                'category' =>   $this->category
            ]);
        } else {
            $exist->update(
                [
                    'show_first' => 0,
                    'show_second' =>  0,
                    'show_third' => 0,
                    'show_all' =>   0,
                    'category' =>   $this->category
                ]
            );
        }
    }
    public function changeFirst()
    {
        LedManagement::where('category', $this->category)->update([
            'show_first' => !$this->show_first,
            'show_third' => 0,
            'show_second' => 0,
            'show_all' => 0
        ]);
    }
    public function changeSecond()
    {
        LedManagement::where('category', $this->category)->update([
            'show_second' => !$this->show_second,
            'show_third' => 0,
            'show_first' => 0,
            'show_all' => 0
        ]);
    }
    public function changeThird()
    {
        LedManagement::where('category', $this->category)->update([
            'show_third' =>  !$this->show_third,
            'show_second' => 0,
            'show_first' => 0,
            'show_all' => 0
        ]);
    }
    public function changeAll()
    {
        LedManagement::where('category', $this->category)->update([
            'show_all' => !$this->show_all,
            'show_third' => 0,
            'show_second' => 0,
            'show_first' => 0
        ]);
    }
}
