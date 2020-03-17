<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FetchPackageMetaDataFromNpmJsRegistry implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    /**
     * The name of the npm package.
     *
     * @var string
     */
    public $name;

    /**
     * Create a new job instance.
     *
     * @param  string  $name
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = Http::get("https://registry.npmjs.org/{$this->name}");

        if (! $response->ok()) {
            abort($response->status());
        }

        Storage::disk('local')->put("npmjs/{$this->name}.json", $response->body());
    }
}
