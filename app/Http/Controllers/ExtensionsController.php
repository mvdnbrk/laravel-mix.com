<?php

namespace App\Http\Controllers;

use App\Models\Extension;
use Illuminate\View\View;

class ExtensionsController
{
    public function index(): View
    {
        $extensions = Extension::latest()->get();

        return view('extensions.index', compact('extensions'));
    }

    public function show(Extension $extension): View
    {
        return view('extensions.show', compact('extension'));
    }
}
