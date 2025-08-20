<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StreetDancingLedController extends Controller
{
    public function index()
    {
        return view('led_display.streetDancing');
    }
}
