<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DocumentationBaseController;

class DocumentationRedirectController extends DocumentationBaseController
{
    /**
     * Redirects to the lastest version of a specific page of the documention.
     * In case a version number is specified it will redirect to the
     * default page of that version.
     *
     * @param string  $page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($page)
    {
        if ($this->documentation->isVersion($page)) {
            return redirect("/docs/{$page}/".config('documentation.default_page'), 301);
        }

        return redirect("/docs/{$this->documentation->defaultVersion()}/{$page}", 301);
    }
}
