<?php

namespace App;

use ParsedownExtra;
use Illuminate\Support\Facades\Storage;

class Documentation
{
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
     * Get all the versions of the documentation.
     *
     * @return \Illuminate\Support\Collection
     */
    public function versions()
    {
        return collect(config('documentation.versions'));
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
        $path = "{$version}/index.md";

        if (Storage::disk('docs')->exists($path)) {
            return (new ParsedownExtra())->text(Storage::disk('docs')->get($path));
        }

        return null;
    }
}
