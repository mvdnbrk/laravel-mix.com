<?php

namespace App\Http\Controllers;

class WelcomeController extends DocumentationBaseController
{
    public function show()
    {
        return view('welcome', [
            'latest_release' => $this->documentation->latestRelease(),
            'documentation_url' => $this->documentation->defaultStartPage(),
        ]);
    }
}
