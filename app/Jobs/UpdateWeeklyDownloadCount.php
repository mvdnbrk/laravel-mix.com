<?php

namespace App\Jobs;

use App\Models\Extension;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class UpdateWeeklyDownloadCount implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    public Extension $extension;

    public function __construct(Extension $extension)
    {
        $this->extension = $extension;
    }

    public function handle()
    {
        // The npm downloads API rate limits bursts of requests with HTTP 429, so back off and retry.
        $response = Http::retry(
            [2000, 5000, 10000, 20000],
            when: fn ($exception) => $exception instanceof RequestException && $exception->response->status() === 429,
        )->get("https://api.npmjs.org/downloads/point/last-week/{$this->extension->name}");

        $this->extension->timestamps = false;

        $this->extension->update([
            'weekly_download_count' => collect($response->json())->get('downloads', 0),
        ]);
    }
}
