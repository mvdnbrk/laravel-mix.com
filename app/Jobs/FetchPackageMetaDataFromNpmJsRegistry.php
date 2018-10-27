<?php

namespace App\Jobs;

use Zttp\Zttp;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        $response = Zttp::get("https://registry.npmjs.org/{$this->name}");

        if ($response->status() !== 200) {
            abort($response->status());
        }

        Storage::disk('local')->put("npmjs/{$this->name}.json", $response->body());
    }
}
