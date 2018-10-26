<?php

namespace App\Http\Controllers;

use App\Extension;
use Illuminate\Http\Request;

class ExtensionsController extends Controller
{
    public function index()
    {
        $extensions = Extension::all();

        return view('extensions.index', compact('extensions'));
    }

    public function show(Extension $extension)
    {
        return view('extensions.show', compact('extension'));
    }
}
