<?php

namespace App\Jobs;

use App\Extension;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FetchReadme implements ShouldQueue
{
    use Dispatchable, SerializesModels;

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

    public function __construct(Extension $extension)
    {
        $this->extension = $extension;
    }

    public function handle()
    {
        collect($this->filenames)
            ->prepend(
                collect($this->extension->getDecodedJson())->get('readmeFilename')
            )
            ->unique()
            ->filter()
            ->when(Cache::has($this->cacheKey()), function (Collection $collection) {
                return $collection->prepend(
                    Cache::pull('extension.readme.filename:'.$this->extension->id)
                );
            })
            ->each(function (string $filename) {
                if ($this->fetchReadme($filename)) {
                    return false;
                }
            });

        if (! Cache::has($this->cacheKey())) {
            abort(404);
        }
    }

    protected function baseUrl(): string
    {
        return Str::replaceFirst(
            'https://github.com',
            'https://raw.githubusercontent.com',
            $this->extension->repositoryUrl
        ).'/master/';
    }

    protected function cacheKey(): string
    {
        return 'extension.readme.filename:'.$this->extension->id;
    }

    protected function fetchReadme(string $filename): bool
    {
        try {
            $response = Http::get($this->baseUrl().$filename);

            $response->throw();

            Storage::disk('local')->put("readme/{$this->extension->name}.md", $response->body());

            Cache::forever($this->cacheKey(), $filename);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
