<?php

namespace Tests\Console;

use App\Jobs\UpdateWeeklyDownloadCount;
use App\Models\Extension;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FetchDownloadCountsCommandTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_spreads_the_download_count_jobs_out_over_time()
    {
        Queue::fake();
        $this->freezeTime();

        Extension::factory()->create(['name' => 'laravel-mix-a']);
        Extension::factory()->create(['name' => 'laravel-mix-b']);
        Extension::factory()->create(['name' => 'laravel-mix-c']);

        $this->artisan('extension:stats')->assertSuccessful();

        $delays = [];
        Queue::assertPushed(UpdateWeeklyDownloadCount::class, function ($job) use (&$delays) {
            $delays[$job->extension->name] = now()->diffInSeconds($job->delay);

            return true;
        });

        $this->assertSame(['laravel-mix-a' => 0.0, 'laravel-mix-b' => 2.0, 'laravel-mix-c' => 4.0], $delays);
    }
}
