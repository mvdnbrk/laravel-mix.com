<?php

namespace App;

use ParsedownExtra;
use Illuminate\Filesystem\Filesystem;

class Documentation
{
    /**
     * The filesystem implementation.
     *
     * @var Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new documentation instance.
     *
     * @param  Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
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
        $path = base_path('storage/docs/'.$version.'/'.$page.'.md');

        if ($this->files->exists($path)) {
            return (new ParsedownExtra())->text($this->files->get($path));
        }

        return null;
    }
}
