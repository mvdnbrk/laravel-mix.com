<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DocumentationBaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class DocumentationRedirectController extends DocumentationBaseController
{
    public function show(string $page): RedirectResponse
    {
        if ($this->documentation->isVersion($page)) {
            return redirect(
                "/docs/{$page}/".$this->documentation->defaultPage(),
                Response::HTTP_SEE_OTHER
            );
        }

        return redirect(
            "/docs/{$this->documentation->defaultVersion()}/{$page}",
            Response::HTTP_SEE_OTHER
        );
    }
}
