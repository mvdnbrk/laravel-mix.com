<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PluginsController extends Controller
{
    public function show()
    {
        return view('plugins');
    }
}
