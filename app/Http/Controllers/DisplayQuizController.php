<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DisplayQuizController extends Controller
{
    public function quiz()
    {
        return view('led_display.quiz');
    }
}
