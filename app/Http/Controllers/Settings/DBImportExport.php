<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DBImportExport extends Controller
{
    public function index()
    {
        return view('settings.db-import-export');
    }
}
