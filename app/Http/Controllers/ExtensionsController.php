<?php

namespace App\Http\Controllers;

use App\Extension;
use Illuminate\Http\Request;

class ExtensionsController extends Controller
{
    /**
     * SHow the extensions index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $extensions = Extension::all();

        return view('extensions.index', compact('extensions'));
    }

    /**
     * SHow the page for an extension.
     *
     * @param \App\Extension
     * @return \Illuminate\View\View
     */
    public function show(Extension $extension)
    {
        return view('extensions.show', compact('extension'));
    }
}
