<?php

namespace App\Http\Controllers\Reference;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    public function index()
    {
        return view('reference.criteria');
    }
}
