<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        return view('quiz');
    }

    public function viewDetails()
    {
        // Logic to fetch and display quiz details
        return view('view-quiz-details');
    }
}
