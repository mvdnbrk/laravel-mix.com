<?php

namespace App\Jobs;

use Zttp\Zttp;
use App\Extension;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateWeeklyDownloadCount implements ShouldQueue
{
    use Dispatchable, SerializesModels;

    /**
     * The extension to update.
     *
     * @var \App\Extension
     */
    public $extension;

    /**
     * Create a new job instance.
     *
     * @param  \App\Extension $extension
     * @return void
     */
    public function __construct(Extension $extension)
    {
        $this->extension = $extension;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = Zttp::get("https://api.npmjs.org/downloads/point/last-week/{$this->extension->name}");

        if ($response->status() !== 200) {
            abort($response->status());
        }

        $this->extension->timestamps = false;

        $this->extension->update([
            'weekly_download_count' => collect(json_decode($response->body(), true))->get('downloads', 0),
        ]);
    }
}
