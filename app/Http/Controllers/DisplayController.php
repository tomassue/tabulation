<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DisplayController extends Controller
{
    public function oral()
    {
        return view('led_display.oral');
    }
}
