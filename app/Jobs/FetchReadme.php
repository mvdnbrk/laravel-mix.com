<?php

namespace App\Jobs;

use App\Models\Extension;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

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
        if ($this->baseUrl()->isEmpty()) {
            $this->storeReadmeFromNpm();

            return;
        }

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
            $this->storeReadmeFromNpm();
        }
    }

    protected function baseUrl(): Stringable
    {
        if ($this->extension->repositoryUrl->isEmpty()) {
            return new Stringable;
        }

        return Str::of($this->extension->repositoryUrl)
            ->replaceFirst('https://github.com', 'https://raw.githubusercontent.com')
            ->finish('/HEAD/');
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

            $this->storeReadme($response->body());

            Cache::forever($this->cacheKey(), $filename);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Use npm's copy of the README when the repository has none.
     */
    protected function storeReadmeFromNpm(): void
    {
        $readme = collect($this->extension->getDecodedJson())->get('readme');

        if (is_string($readme) && trim($readme) !== '' && $readme !== 'ERROR: No README data found!') {
            $this->storeReadme($readme);
        }
    }

    protected function storeReadme(string $content): bool
    {
        return tap(
            Storage::put($this->extension->readmeStoragePath(), $content),
            fn () => $this->extension->clearPageCache()
        );
    }
}
