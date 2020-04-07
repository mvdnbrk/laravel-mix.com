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
        $documentation_url = route('documentation.show', [
            'version' => $this->documentation->defaultVersion(),
            'page' => $this->documentation->defaultPage(),
        ]);

        return view('welcome', [
            'latest_release' => $this->documentation->defaultVersion(),
            'documentation_url' => $documentation_url,
        ]);
    }
}
