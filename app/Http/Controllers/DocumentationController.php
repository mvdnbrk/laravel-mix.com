<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DocumentationBaseController;
use Illuminate\Http\Response;
use Symfony\Component\DomCrawler\Crawler;

class DocumentationController extends DocumentationBaseController
{
    /**
     * Show a documentation page.
     *
     * @param  string  $version
     * @param  string  $page
     * @return \Illuminate\View\View
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function show($version, $page)
    {
        $content = $this->documentation->get($version, $page);

        if (is_null($content)) {
            abort(Response::HTTP_NOT_FOUND);
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
