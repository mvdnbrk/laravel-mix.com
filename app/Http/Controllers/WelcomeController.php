<?php

namespace App\Http\Controllers;

use App\Documentation;

class WelcomeController extends Controller
{
    public function show()
    {
        $default_docs_start_page = (new Documentation)->defaultStartPage();

        return view('welcome', compact('default_docs_start_page'));
    }
}
