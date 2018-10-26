<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Extension extends Model
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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
        if (! Storage::exists($this->getJsonStoragePath())) {
            return json_encode(new \stdClass);
        }

        return Storage::get($this->getJsonStoragePath());
    }

    /**
     * Get the storage path to the json file.
     *
     * @return string
     */
    public function getJsonStoragePath()
    {
        return "npmjs/{$this->name}.json";
    }

    public function getKeyWordsAttribute()
    {
        $array = collect(json_decode($this->getJson()), true)->get('keywords');

        return collect($array)->reject(function ($keyword) {
            return in_array($keyword, [
                \Illuminate\Support\Str::lower($this->getTitleAttribute()),
                'laravel-mix',
                'laravel mix',
                'laravel',
                'mix',
                'webpack',
            ]);
        });
    }

    /**
     * Get the latest published version number.
     *
     * @return string
     */
    public function getLatestVersionAttribute()
    {
        return str_start($this->latest_dist_tag, 'v');
    }

    /**
     * Determine if this is a git repository.
     *
     * @return boolean
     */
    public function isGitRepository()
    {
        return collect(json_decode($this->repository, true))->get('type') === 'git';
    }

    /**
     * Get the url of the repository.
     *
     * @return string
     */
    public function getRepositoryUrlAttribute()
    {
        $url = collect(json_decode($this->repository, true))->get('url');

        if (substr($url, 0, strlen('git+')) == 'git+') {
            $url = substr($url, strlen('git+'));
        }

        if (substr($url, -strlen('.git')) == '.git') {
            $url = substr($url, 0, strlen($url) - strlen('.git'));
        }

        return $url;
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
}
