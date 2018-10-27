<?php

namespace App\Jobs;

use Zttp\Zttp;
use App\Extension;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;

class FetchReadme implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    /**
     * The filenames that may exists for a repository.
     * Most common used first.
     *
     * @var array
     */
    protected $filenames = [
        'README.md',
        'readme.md',
        'Readme.md',
        'README.markdown',
        'readme.markdown',
        'README.mdown',
        'readme.mdown',
        'README.mkdn',
        'readme.mkdn',
    ];

    /**
     * The extension to fetch the README file for.
     *
     * @var string
     */
    public $extension;

    /**
     * Create a new job instance.
     *
     * @param  string  $name
     * @return void
     */
    public function __construct(Extension $extension)
    {
        $this->extension = $extension;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        collect($this->filenames)
            ->when(cache()->has($this->cacheKey()), function($collection) {
                return $collection->prepend(
                    cache()->pull('extension.readme.filename:'.$this->extension->id)
                );
            })
            ->each(function ($filename) {
                if ($this->fetchReadme($filename)) {
                    return false;
                }
            });

        if (! cache()->has($this->cacheKey())) {
            abort(404);
        }
    }

    /**
     * Get the base url for the repository.
     *
     * @return string
     */
    protected function baseUrl()
    {
        return str_replace_first(
            'https://github.com',
            'https://raw.githubusercontent.com',
            $this->extension->repositoryUrl
        ).'/master/';
    }

    /**
     * Get the cache key name.
     *
     * @return string
     */
    private function cacheKey()
    {
        return 'extension.readme.filename:'.$this->extension->id;
    }

    /**
     * Fetch the readme from the respository and store it locally.
     *
     * @param string  $filename
     * @return bool
     */
    protected function fetchReadme($filename)
    {
        try {
            $response = Zttp::get($this->baseUrl().$filename);

            if ($response->status() !== 200) {
                abort(404);
            }

            Storage::disk('local')->put("readme/{$this->extension->name}.md", $response->body());
            cache()->forever($this->cacheKey(), $filename);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
