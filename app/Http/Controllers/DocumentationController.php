<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DocumentationController extends DocumentationBaseController
{
    /**
     * Show a documentation page.
     *
     *
     * @throws NotFoundHttpException
     */
    public function show(string $version, string $page): View
    {
        $content = $this->documentation->get($version, $page);

        if (empty($content->toHtml())) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $title = (new Crawler($content->toHtml()))->filterXPath('//h1');

        $canonical = null;

        if ($this->documentation->sectionExists($this->documentation->defaultVersion(), $page)) {
            $canonical = route('documentation.show', [
                'version' => $this->documentation->defaultVersion(),
                'page' => $page,
            ]);
        }

        return view('documentation', [
            'title' => count($title) ? $title->text() : null,
            'canonical' => $canonical,
            'index' => $this->documentation->getIndex($version),
            'content' => $content,
            'versions' => $this->documentation->versions(),
            'currentVersion' => $version,
            'versionsContainingPage' => $this->documentation->versionsContainingPage($page),
            'page' => $page,
        ]);
    }
}
