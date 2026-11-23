<?php

namespace Tests\Feature;

use App\Jobs\UpdateExtensionModelFromJson;
use App\Jobs\UpdateWeeklyDownloadCount;
use App\Models\Extension;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ExtensionReleaseDateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake();
        Storage::put('npmjs/laravel-mix-imagemin.json', json_encode([
            'name' => 'laravel-mix-imagemin',
            'description' => 'Imagemin extension',
            'dist-tags' => ['latest' => '1.0.3'],
            'versions' => ['1.0.2' => [], '1.0.3' => []],
            'time' => [
                'created' => '2018-02-01T10:00:00.000Z',
                'modified' => '2022-05-07T15:59:52.226Z',
                '1.0.2' => '2019-01-10T12:00:00.000Z',
                '1.0.3' => '2019-06-22T00:36:23.016Z',
            ],
        ]));
    }

    #[Test]
    public function it_stores_the_release_time_of_the_latest_version()
    {
        $extension = Extension::factory()->create(['name' => 'laravel-mix-imagemin']);

        UpdateExtensionModelFromJson::dispatchSync($extension);

        $this->assertSame(
            '2019-06-22 00:36:23',
            $extension->fresh()->published_at->format('Y-m-d H:i:s')
        );
    }

    #[Test]
    public function the_release_date_does_not_change_when_the_nightly_jobs_run_again()
    {
        $extension = Extension::factory()->create(['name' => 'laravel-mix-imagemin']);
        UpdateExtensionModelFromJson::dispatchSync($extension);

        $this->travel(1)->day();
        UpdateExtensionModelFromJson::dispatchSync($extension->fresh());

        Http::fake(['*' => Http::response(['downloads' => 123])]);
        UpdateWeeklyDownloadCount::dispatchSync($extension->fresh());

        $this->assertSame('2019-06-22', $extension->fresh()->published_at->toDateString());
    }

    #[Test]
    public function the_extension_page_shows_the_release_date_of_the_latest_version()
    {
        $this->travelTo('2026-11-23 12:00:00');

        $extension = Extension::factory()->create(['name' => 'laravel-mix-imagemin']);
        UpdateExtensionModelFromJson::dispatchSync($extension);

        $this->get('/extensions/imagemin')
            ->assertOk()
            ->assertSee('released <time datetime="2019-06-22T00:36:23.000000Z">7 years ago</time>', false);
    }

    #[Test]
    public function the_extension_page_omits_the_release_date_when_it_is_unknown()
    {
        Extension::factory()->create(['slug' => 'no-date', 'published_at' => null]);

        $this->get('/extensions/no-date')
            ->assertOk()
            ->assertDontSee('released');
    }
}
