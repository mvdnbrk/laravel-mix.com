<?php

namespace App\Jobs;

use App\Extension;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class UpdateExtensionModelFromJson implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    public Extension $extension;

    protected Collection $data;

    public function __construct(Extension $extension)
    {
        $this->extension = $extension;

        $this->data = collect($this->extension->getDecodedJson());
    }

    public function handle()
    {
        if ($this->data->isEmpty()) {
            return;
        }

        $this->extension->update([
            'slug' => $this->getSlug(),
            'author_name' => $this->getAuthorName(),
            'author_email' => $this->getAuthorEmail(),
            'description' => $this->getDescription(),
            'latest_dist_tag' => $this->getLatestDistTag(),
            'version_count' => $this->getVersionCount(),
            'license' => $this->data->get('license'),
            'repository' => $this->getRepository(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
        ]);
    }

    protected function getAuthorName()
    {
        return collect($this->data->get('author'))->get('name');
    }

    protected function getAuthorEmail()
    {
        return collect($this->data->get('author'))->get('email');
    }

    protected function getLatestDistTag()
    {
        return collect($this->data->get('dist-tags'))->get('latest');
    }

    protected function getCreatedAt()
    {
        $createdAt = collect($this->data->get('time'))->get('created');

        return new Carbon($createdAt);
    }

    protected function getDescription()
    {
        $description = $this->data->get('description');

        $description = Str::finish($description, '.');

        return Str::ucfirst($description);
    }

    protected function getRepository()
    {
        return $this->data->get('repository');
    }

    protected function getSlug()
    {
        return Str::slug($this->stripLaravelMixFromName());
    }

    protected function getUpdatedAt()
    {
        $updatedAt = collect($this->data->get('time'))->get('modified');

        return new Carbon($updatedAt);
    }

    public function getVersionCount()
    {
        return collect($this->data->get('versions'))->count();
    }

    protected function stripLaravelMixFromName()
    {
        $name = $this->data->get('name');

        if (substr($name, 0, strlen('mix-')) == 'mix-') {
            $name = substr($name, strlen('mix-'));
        }

        if (substr($name, 0, strlen('laravel-mix-')) == 'laravel-mix-') {
            $name = substr($name, strlen('laravel-mix-'));
        }

        return $name;
    }
}
