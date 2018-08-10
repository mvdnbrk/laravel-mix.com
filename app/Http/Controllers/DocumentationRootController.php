<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DocumentationBaseController;

class DocumentationRootController extends DocumentationBaseController
{
    /**
     * A request to the index of /docs redirects to
     * the latest version of the documentation.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function show()
    {
        return redirect('/docs/'.$this->documentation->defaultVersion(), 302);
    }
}
