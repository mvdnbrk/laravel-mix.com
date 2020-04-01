<?php

namespace App\Jobs;

use Exception;
use App\Extension;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FetchReadme implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    /**
     * The filenames that may exists for a repository.
     * Most common used first.
     *
     * @var array
     */
    public Extension $extension;
    protected array $filenames = [
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
     * @var \App\Extension
     */

    /**
     * Create a new job instance.
     *
     * @param  \App\Extension  $extension
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
            ->when(cache()->has($this->cacheKey()), function ($collection) {
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
    protected function baseUrl(): string
    {
        return Str::replaceFirst(
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
    protected function cacheKey(): string
    {
        return 'extension.readme.filename:'.$this->extension->id;
    }

    /**
     * Fetch the readme from the respository and store it locally.
     *
     * @param  string  $filename
     * @return bool
     */
    protected function fetchReadme(string $filename): bool
    {
        try {
            $response = Http::get($this->baseUrl().$filename);

            if (! $response->ok()) {
                abort(404);
            }

            Storage::disk('local')->put("readme/{$this->extension->name}.md", $response->body());

            cache()->forever($this->cacheKey(), $filename);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
