<?php

namespace App\Jobs;

use App\Extension;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateExtensionModelFromJson implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    /**
     * The extension to update.
     *
     * @var string
     */
    public $extension;

    /**
     * The data associated with this extension.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $data;

    /**
     * Create a new job instance.
     *
     * @param  string  $name
     * @return void
     */
    public function __construct(Extension $extension)
    {
        $this->extension = $extension;

        $this->data = collect(json_decode($this->extension->getJson(), true));
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
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

        $description = str_finish($description, '.');

        return \Illuminate\Support\Str::ucfirst($description);
    }

    protected function getRepository()
    {
        return json_encode($this->data->get('repository'));
    }

    protected function getSlug()
    {
        return str_slug($this->stripLaravelMixFromName());
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
        $name = str_replace_first('mix-', '', $this->data->get('name'));
        $name = str_replace_first('laravel-mix-', '', $this->data->get('name'));

        return $name;
    }
}