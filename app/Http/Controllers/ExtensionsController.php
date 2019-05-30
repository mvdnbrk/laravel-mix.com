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
        $extensions = Extension::latest()->get();

        return view('extensions.index', compact('extensions'));
    }

    /**
     * Show the page for an extension.
     *
     * @param  \App\Extension  $extension
     * @return \Illuminate\View\View
     */
    public function show(Extension $extension)
    {
        return view('extensions.show', compact('extension'));
    }
}
