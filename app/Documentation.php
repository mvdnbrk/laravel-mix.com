<?php

namespace App;

use ParsedownExtra;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Documentation
{
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

        return $this->versions()->reject(function($value) {
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
    public function get($version, $page)
    {
        if ($this->isExcludedPage($page)) {
            return null;
        }

        $path = "{$version}/{$page}.md";

        if (Storage::disk('docs')->exists($path)) {
            return (new ParsedownExtra())->text(Storage::disk('docs')->get($path));
        }

        return null;
    }

    /**
     * Get the documentation index page.
     *
     * @param  string  $version
     * @return string|null
     */
    public function getIndex($version)
    {
        if (! Storage::disk('docs')->exists($this->getIndexPath($version))) {
            return null;
        }

        return $this->replaceLinks(
            $version,
            (new ParsedownExtra())->text(Storage::disk('docs')->get($path))
        );
    }

    /**
     * Get the documentation index payh.
     *
     * @param  string  $version
     * @return string
     */
    public function getIndexPath($version)
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
     * @param string  $page
     * @return boolean
     */
    public function isExcludedPage($page)
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
    public function isVersion($version)
    {
        return $this->versions()->contains($version);
    }

    /**
     * Replace the version place-holder in links.
     *
     * @param  string  $version
     * @param  string  $content
     * @return string
     */
    public static function replaceLinks($version, $content)
    {
        return str_replace('{{version}}', $version, $content);
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
