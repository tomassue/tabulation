<?php

namespace App\Http\Controllers\Reference;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JudgesController extends Controller
{
    public function index()
    {
        return view('reference.judges');
    }
}
