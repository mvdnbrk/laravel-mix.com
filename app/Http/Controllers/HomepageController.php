<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomepageController extends DocumentationBaseController
{
    /**
     * Show the homepage.
     *
     * @return \Illuminate\View\View
     */
    public function show(): View
    {
        $documentation_url = route('documentation.show', [
            'version' => $this->documentation->defaultVersion(),
            'page' => $this->documentation->defaultPage(),
        ]);

        return view('welcome', [
            'documentation_url' => $documentation_url,
        ]);
    }
}
