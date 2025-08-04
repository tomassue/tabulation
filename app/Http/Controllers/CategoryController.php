<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($slug)
    {
        $category = Cache::remember("category_{$slug}", 3600, function () use ($slug) {
            return Category::where('category', $slug)
                ->where('is_active', 1)
                ->firstOrFail();
        });

        return view('category', compact('category'));
    }
}
