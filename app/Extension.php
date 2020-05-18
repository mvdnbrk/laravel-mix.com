<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Mvdnbrk\Documentation\Markdown;

class Extension extends Model
{
    use SoftDeletes;

    protected $casts = [
        'repository' => 'array',
        'version_count' => 'integer',
        'weekly_download_count' => 'integer',
    ];

    protected $guarded = [];

    protected array $decoded_json;

    protected static function booted(): void
    {
        static::addGlobalScope('sorted', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getJson(): string
    {
        if (! Storage::exists($this->jsonStoragePath())) {
            return json_encode(new \stdClass);
        }

        return Storage::get($this->jsonStoragePath());
    }

    public function getDecodedJson(): array
    {
        return $this->decoded_json ??= json_decode($this->getJson(), true);
    }

    public function jsonStoragePath(): string
    {
        return "npmjs/{$this->name}.json";
    }

    public function readmeStoragePath(): string
    {
        return "readme/{$this->name}.md";
    }

    public function getKeyWordsAttribute(): array
    {
        return Cache::remember('extension.keywords:'.$this->id, now()->addDay(), function () {
            $keywords = collect($this->getDecodedJson())->get('keywords');

            return collect($keywords)
                ->diff($this->getUnpermittedKeywords())
                ->values()
                ->all();
        });
    }

    /**
     * Get unpermitted keywords including a maintainers name.
     *
     * @return array
     */
    protected function getUnpermittedKeywords(): array
    {
        return collect($this->getMaintainersAttribute())
            ->keys()
            ->merge([
                Str::lower($this->getTitleAttribute()),
                'extension',
                'laravel-mix',
                'laravel mix',
                'laravel',
                'mix',
                'plugin',
                'webpack',
            ])
            ->all();
    }

    /**
     * Get the maintainers for this extension.
     * Returns an array with the name as key and email as value.
     *
     * @return array
     */
    public function getMaintainersAttribute(): array
    {
        return Cache::remember('extension.maintainers:'.$this->id, now()->addDay(), function () {
            $maintainers = collect($this->getDecodedJson())->get('maintainers', []);

            return collect($maintainers)
                ->mapWithKeys(function ($maintainer) {
                    return [$maintainer['name'] => Str::lower($maintainer['email'])];
                })
                ->toArray();
        });
    }

    public function getLatestVersionAttribute(): string
    {
        return Str::start($this->latest_dist_tag, 'v');
    }

    public function getReadmeAttribute(): string
    {
        if (! $this->hasLocalReadme()) {
            return '';
        }

        return Markdown::parse(
            $this->replaceExternalLinks(
                Storage::get($this->readmeStoragePath()
            )
        ));
    }

    public function replaceExternalLinks(string $content): string
    {
        return preg_replace_callback('/\[(.*?)\]\((?!http)(.*?)\)/m', function ($matches) {
            if ($this->repositoryUrl->isEmpty()) {
                return $matches[1];
            }

            return '['.$matches[1].']('.$this->repositoryUrl.'/blob/master/'.$matches[2].')';
        }, $content);
    }

    public function getRepositoryUrlAttribute(): Stringable
    {
        return Cache::remember('extension.repository-url:'.$this->id, now()->addDay(), function () {
            if (! $url = collect($this->repository)->get('url')) {
                return new Stringable;
            }

            return Str::of($url)
                ->after('git+')
                ->after('git://')
                ->before('.git')
                ->start('https://');
        });
    }

    public function getTitleAttribute(): Stringable
    {
        return Str::of($this->slug)->slug(' ')->title();
    }

    public function hasLocalReadme(): bool
    {
        return Storage::exists($this->readmeStoragePath());
    }

    public function getRepositoryTypeAttribute(): string
    {
        return Cache::remember('extension.repository-type:'.$this->id, now()->addDay(), function () {
            return collect($this->repository)->get('type', '');
        });
    }

    public function isGitRepository(): bool
    {
        return $this->getRepositoryTypeAttribute() === 'git';
    }

    public function clearPageCache(): void
    {
        Artisan::queue('page-cache:clear', [
            'slug' => route('extensions.show', $this, false),
        ]);
    }
}
