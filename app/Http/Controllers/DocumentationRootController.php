<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DocumentationBaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class DocumentationRootController extends DocumentationBaseController
{
    /**
     * A request to the index of /docs redirects to
     * the latest version of the documentation.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(): RedirectResponse
    {
        return redirect(
            '/docs/'.$this->documentation->defaultVersion(),
            Response::HTTP_SEE_OTHER
        );
    }
}
