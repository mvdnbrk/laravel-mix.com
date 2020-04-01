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

    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Execute the job.
     *
     * @return void
     *
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function handle()
    {
        $response = Http::get("https://registry.npmjs.org/{$this->name}");

        $response->throw();

        Storage::disk('local')->put("npmjs/{$this->name}.json", $response->body());
    }
}
