<?php

namespace App\Http\Controllers;

class WelcomeController extends DocumentationBaseController
{
    public function show()
    {
        $default_docs_start_page = $this->documentation->defaultStartPage();

        return view('welcome', compact('default_docs_start_page'));
    }
}
