<?php

namespace App\Livewire;

use App\Models\LedManagement;
use Livewire\Component;

class DisplayManagement extends Component
{
    public $id, $category, $show_first = false, $show_second = false, $show_third = false, $show_all = false;
    public function render()
    {
        $leds = LedManagement::get();
        $this->category = $leds->first()->category;
        $this->show_first = $leds->where('category', $this->category)->first()->show_first;
        $this->show_second = $leds->where('category', $this->category)->first()->show_second;
        $this->show_third = $leds->where('category', $this->category)->first()->show_third;
        $this->show_all = $leds->where('category', $this->category)->first()->show_all;
        return view('livewire.display-management', compact('leds'));
    }
    public function changeCategory()
    {
        LedManagement::first()->update([
            'show_first' => 0,
            'show_second' =>  0,
            'show_third' => 0,
            'show_all' =>   0,
            'category' =>   $this->category
        ]);
    }
    public function changeFirst()
    {
        LedManagement::where('category', $this->category)->update([
            'show_first' => !$this->show_first,
            'show_third' => 0,
            'show_second' => 0
        ]);
    }
    public function changeSecond()
    {
        LedManagement::where('category', $this->category)->update([
            'show_second' => !$this->show_second,
            'show_third' => 0,
            'show_first' => 0
        ]);
    }
    public function changeThird()
    {
        LedManagement::where('category', $this->category)->update([
            'show_third' =>  !$this->show_third,
            'show_second' => 0,
            'show_first' => 0
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
