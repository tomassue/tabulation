<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DisplayPosterController extends Controller
{
    public function poster()
    {
        return view('led_display.poster');
    }

    public function output()
    {
        return view('led_display.poster_output');
    }
}
