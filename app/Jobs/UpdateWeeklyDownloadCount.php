<?php

namespace App\Jobs;

use App\Extension;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class UpdateWeeklyDownloadCount implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    public Extension $extension;

    public function __construct(Extension $extension)
    {
        $this->extension = $extension;
    }

    public function handle()
    {
        $response = Http::get("https://api.npmjs.org/downloads/point/last-week/{$this->extension->name}");

        $response->throw();

        $this->extension->timestamps = false;

        $this->extension->update([
            'weekly_download_count' => collect(json_decode($response->body(), true))->get('downloads', 0),
        ]);
    }
}
