<?php

namespace App;

use ParsedownExtra;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Extension extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'version_count' => 'integer',
        'weekly_download_count' => 'integer',
    ];


    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sorted', function ($builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the json meta data for this package from storage.
     *
     * @return string
     */
    public function getJson()
    {
        if (! Storage::exists($this->jsonStoragePath())) {
            return json_encode(new \stdClass);
        }

        return Storage::get($this->jsonStoragePath());
    }

    /**
     * Get the decoded json meta data.
     *
     * @return array
     */
    public function getDecodedJson()
    {
        return json_decode($this->getJson(), true);
    }

    /**
     * Get the storage path for the json file.
     *
     * @return string
     */
    public function jsonStoragePath()
    {
        return "npmjs/{$this->name}.json";
    }

    /**
     * Get the storage path for the README file.
     *
     * @return string
     */
    public function readmeStoragePath()
    {
        return "readme/{$this->name}.md";
    }

    /**
     * Get keywords for this extension.
     *
     * @return array
     */
    public function getKeyWordsAttribute()
    {
        return cache()->remember('extension.keywords:'.$this->id, now()->addDay(), function () {
            $array = collect($this->getDecodedJson())->get('keywords');

            return collect($array)->reject(function ($keyword) {
                return in_array($keyword, $this->getUnpermittedKeywords());
            })->toArray();
        });
    }

    /**
     * Get unpermitted keywords including a maintainers name.
     *
     * @return array
     */
    protected function getUnpermittedKeywords()
    {
        return array_merge(
            collect($this->getMaintainersAttribute())->keys()->toArray(),
            [
                Str::lower($this->getTitleAttribute()),
                'laravel-mix',
                'laravel mix',
                'laravel',
                'mix',
                'webpack',
            ]
        );
    }

    /**
     * Get the maintainers for this extension.
     * Returns an array with the name as key and email as value.
     *
     * @return array
     */
    public function getMaintainersAttribute()
    {
        return cache()->remember('extension.maintainers:'.$this->id, now()->addDay(), function () {
            $maintainers = collect($this->getDecodedJson())->get('maintainers', []);

            return collect($maintainers)
                ->mapWithKeys(function ($maintainer) {
                    return [$maintainer['name'] => Str::lower($maintainer['email'])];
                });
        });
    }

    /**
     * Get the latest published version number.
     *
     * @return string
     */
    public function getLatestVersionAttribute()
    {
        return Str::start($this->latest_dist_tag, 'v');
    }

    /**
     * Get the readme..
     *
     * @return string
     */
    public function getReadmeAttribute()
    {
        if ($this->hasLocalReadme()) {
            return (new ParsedownExtra())->text(
                $this->replaceExternalLinks(
                    Storage::get($this->readmeStoragePath()
                )
            ));
        }

        return '';
    }

    /**
     * Replace links to external links if needed.
     *
     * @param  string  $content
     * @return string
     */
    public function replaceExternalLinks($content)
    {
        return preg_replace_callback('/\[(.*)\]\((?!http)(.*\.{1}.*)\)/m', function ($matches) {
            return '['.$matches[1].']('.$this->repositoryUrl.'/blob/master/'.$matches[2].')';
        }, $content);
    }

    /**
     * Get the url of the repository.
     *
     * @return string
     */
    public function getRepositoryUrlAttribute()
    {
        return cache()->remember('extension.repository-url:'.$this->id, now()->addDay(), function () {
            $url = collect(json_decode($this->repository, true))->get('url');

            if (substr($url, 0, strlen('git+')) == 'git+') {
                $url = substr($url, strlen('git+'));
            }

            if (substr($url, 0, strlen('git')) == 'git') {
                $url = substr($url, strlen('git'));
            }

            if (substr($url, -strlen('.git')) == '.git') {
                $url = substr($url, 0, strlen($url) - strlen('.git'));
            }

            $url = Str::start($url, 'https');

            return $url;
        });
    }

    /**
     * Get the title.
     *
     * @return string
     */
    public function getTitleAttribute()
    {
        return title_case(str_slug($this->slug, ' '));
    }

    /**
     * Determine if this extension has a README file in local storage.
     *
     * @return boolean
     */
    public function hasLocalReadme()
    {
        return Storage::exists($this->readmeStoragePath());
    }

    /**
     * Determine the respository type.
     *
     * @return string
     */
    public function getRepositoryTypeAttribute()
    {
        return cache()->remember('extension.repository-type:'.$this->id, now()->addDay(), function () {
            return collect(json_decode($this->repository, true))->get('type', '');
        });
    }

    /**
     * Determine if this is a git repository.
     *
     * @return boolean
     */
    public function isGitRepository()
    {
        return $this->getRepositoryTypeAttribute() === 'git';
    }
}
