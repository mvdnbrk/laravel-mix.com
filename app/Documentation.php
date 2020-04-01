<?php

namespace App;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Documentation
{
    /**
     * Get the canonical url for a page.
     *
     * @param  string  $page
     * @return string|null
     */
    public function canonicalUrl(string $page)
    {
        if (! $this->pageExists($this->defaultVersion(), $page)) {
            return;
        }

        return $this->url($this->defaultVersion(), $page);
    }

    /**
     * Get the default page of the documentation.
     *
     * @return string
     */
    public function defaultPage()
    {
        return config('documentation.default_page');
    }

    /**
     * Get the default start page of the documentation.
     *
     * @return string
     */
    public function defaultStartPage()
    {
        return "/docs/{$this->defaultVersion()}/{$this->defaultPage()}";
    }

    /**
     * Get the default version of the documentation.
     *
     * @return string
     */
    public function defaultVersion()
    {
        if (config('documentation.default_version') && $this->isVersion(config('documentation.default_version'))) {
            return config('documentation.default_version');
        }

        return $this->versions()->reject(function ($value) {
            return $value == 'master';
        })->first();
    }

    /**
     * Get the given documentation page.
     * Returns null if the given page does not exist.
     *
     * @param  string  $version
     * @param  string  $page
     * @return string|null
     */
    public function get(string $version, string $page)
    {
        if ($this->isExcludedPage($page)) {
            return;
        }

        if (Storage::disk('docs')->exists(
            $this->path($version, $page)
        )) {
            return Markdown::convertToHtml(Storage::disk('docs')->get(
                $this->path($version, $page)
            ));
        }
    }

    /**
     * Get the documentation index page.
     *
     * @param  string  $version
     * @return string|null
     */
    public function getIndex(string $version)
    {
        $path = $this->getIndexPath($version);

        if (! Storage::disk('docs')->exists($path)) {
            return;
        }

        return Markdown::convertToHtml(
            $this->replaceLinks($version, Storage::disk('docs')->get($path))
        );
    }

    /**
     * Get the documentation index payh.
     *
     * @param  string  $version
     * @return string
     */
    public function getIndexPath(string $version)
    {
        return $version.'/'.config('documentation.table_of_contents').'.md';
    }

    /**
     * Get the latest release version of the package.
     *
     * @return string
     */
    public function latestRelease()
    {
        if ($latest = config('documentation.latest_release')) {
            return $latest;
        }

        return $this->defaultVersion();
    }

    /**
     * Determines if a page is excluded from the documentation.
     *
     * @param  string  $page
     * @return bool
     */
    public function isExcludedPage(string $page)
    {
        return collect(config('documentation.excluded_pages'))
            ->push(config('documentation.table_of_contents'))
            ->contains(Str::lower($page));
    }

    /**
     * Determine if the given version is a valid version.
     *
     * @param  string  $version
     * @return bool
     */
    public function isVersion(string $version)
    {
        return $this->versions()->contains($version);
    }

    /**
     * Retrieve the path to a page.
     *
     * @param  string  $version
     * @param  string  $page
     * @return string
     */
    public function path(string $version, string $page)
    {
        return "{$version}/{$page}.md";
    }

    /**
     * Determine if a page exists.
     *
     * @param  string  $version
     * @param  string  $page
     * @return bool
     */
    public function pageExists(string $version, string $page)
    {
        if ($this->isExcludedPage($page)) {
            return false;
        }

        if (! $this->isVersion($version)) {
            return false;
        }

        return Storage::disk('docs')->exists(
            $this->path($version, $page)
        );
    }

    /**
     * Determine in which versions a page exists.
     * Returns an array with the version as key
     * and the url of a page as value.
     *
     * @param  string  $page
     * @return array
     */
    public function pageExistsInVersions(string $page)
    {
        return $this->versions()->mapWithKeys(function ($version) use ($page) {
            return [$version => $this->url($version, $page)];
        })->filter(function ($url, $version) use ($page) {
            return $this->pageExists($version, $page);
        })->toArray();
    }

    /**
     * Replace the version place-holder in links
     * and convert links to a full url.
     *
     * @param  string  $version
     * @param  string  $content
     * @return string
     */
    public function replaceLinks(string $version, string $content)
    {
        return $this->replaceLinksToFullUrl(
            $this->replaceVersion($version, $content)
        );
    }

    /**
     * Replace the all links to a full url.
     *
     * @param  string  $content
     * @return string
     */
    public function replaceLinksToFullUrl(string $content)
    {
        return preg_replace_callback('/\([\/](.*)\)/m', function ($matches) {
            return '('.url($matches[1]).')';
        }, $content);
    }

    /**
     * Replace the version place-holder in links.
     *
     * @param  string  $version
     * @param  string  $content
     * @return string
     */
    public function replaceVersion(string $version, string $content)
    {
        return str_replace('{{version}}', $version, $content);
    }

    /**
     * Get the canonical url for a page.
     *
     * @param  string  $version
     * @param  string  $page
     * @return string|null
     */
    public function url(string $version, string $page)
    {
        return route('documentation.show', [
            'version' => $version,
            'page' => $page,
        ]);
    }

    /**
     * Get all the versions of the documentation.
     *
     * @return \Illuminate\Support\Collection
     */
    public function versions()
    {
        return collect(config('documentation.versions'));
    }
}
