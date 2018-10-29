<?php

namespace App\Http\Controllers;

use Symfony\Component\DomCrawler\Crawler;
use App\Http\Controllers\DocumentationBaseController;

class DocumentationController extends DocumentationBaseController
{
    /**
     * Show a documentation page.
     *
     * @param  string $version
     * @param  string $page
     * @return \Illuminate\View\View
     */
    public function show($version, $page)
    {
        $content = $this->documentation->get($version, $page);

        if (is_null($content)) {
            abort(404);
        }

        $title = (new Crawler($content))->filterXPath('//h1');

        return view('documentation', [
            'title' => count($title) ? $title->text() : null,
            'canonical' => $this->documentation->canonicalUrl($page),
            'index' => $this->documentation->getIndex($version),
            'content' => $content,
            'versions' => $this->documentation->versions(),
            'currentVersion' => $version,
            'pageExistsInVersions' => $this->documentation->pageExistsInVersions($page),
            'page' => $page,
        ]);
    }
}
