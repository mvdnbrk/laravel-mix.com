<?php

namespace App\Http\Controllers;

class HomepageController extends DocumentationBaseController
{
    /**
     * Show the homepage.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('welcome', [
            'latest_release' => $this->documentation->latestRelease(),
            'documentation_url' => $this->documentation->defaultStartPage(),
        ]);
    }
}
