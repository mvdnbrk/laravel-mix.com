<?php

namespace Tests\Feature;

use App\Jobs\FetchPackageMetaDataFromNpmJsRegistry;
use App\Jobs\FetchReadme;
use App\Jobs\UpdateWeeklyDownloadCount;
use App\Models\Extension;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Sleep;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class NightlyJobsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake();
        Sleep::fake();
        Http::preventStrayRequests();
    }

    #[Test]
    public function an_unpublished_package_is_soft_deleted_instead_of_stored()
    {
        $extension = Extension::factory()->create(['name' => 'laravel-mix-eta']);

        Http::fake(['registry.npmjs.org/*' => Http::response([
            'name' => 'laravel-mix-eta',
            'time' => [
                'created' => '2022-01-05T07:44:26.221Z',
                'unpublished' => ['time' => '2023-08-17T08:27:00.124Z', 'versions' => ['0.3.0']],
            ],
        ])]);

        FetchPackageMetaDataFromNpmJsRegistry::dispatchSync('laravel-mix-eta');

        $this->assertSoftDeleted($extension);
        Storage::assertMissing('npmjs/laravel-mix-eta.json');
    }

    #[Test]
    public function a_published_package_is_stored()
    {
        Extension::factory()->create(['name' => 'laravel-mix-polyfill']);

        Http::fake(['registry.npmjs.org/*' => Http::response(['name' => 'laravel-mix-polyfill', 'time' => []])]);

        FetchPackageMetaDataFromNpmJsRegistry::dispatchSync('laravel-mix-polyfill');

        Storage::assertExists('npmjs/laravel-mix-polyfill.json');
    }

    #[Test]
    public function the_download_count_retries_when_npm_rate_limits()
    {
        $extension = Extension::factory()->create(['name' => 'laravel-mix-polyfill']);

        Http::fake(['api.npmjs.org/*' => Http::sequence()
            ->push('error code: 1015', 429)
            ->push('error code: 1015', 429)
            ->push(['downloads' => 21052])]);

        UpdateWeeklyDownloadCount::dispatchSync($extension);

        $this->assertSame(21052, $extension->fresh()->weekly_download_count);
        Http::assertSentCount(3);
    }

    #[Test]
    public function the_download_count_does_not_retry_other_errors()
    {
        $extension = Extension::factory()->create(['name' => 'laravel-mix-gone']);

        Http::fake(['api.npmjs.org/*' => Http::response(['error' => 'package laravel-mix-gone not found'], 404)]);

        try {
            UpdateWeeklyDownloadCount::dispatchSync($extension);
            $this->fail('Expected a RequestException.');
        } catch (RequestException $e) {
            $this->assertSame(404, $e->response->status());
        }

        Http::assertSentCount(1);
    }

    #[Test]
    public function the_readme_falls_back_to_npm_when_the_repository_has_none()
    {
        $extension = Extension::factory()->create([
            'name' => 'laravel-mix-serve',
            'slug' => 'serve',
            'repository' => ['type' => 'git', 'url' => 'git+https://github.com/example/laravel-mix-serve.git'],
        ]);
        Storage::put('npmjs/laravel-mix-serve.json', json_encode(['readme' => '# Serve from npm']));

        Http::fake(['raw.githubusercontent.com/*' => Http::response('Not Found', 404)]);

        FetchReadme::dispatchSync($extension);

        $this->assertSame('# Serve from npm', Storage::get($extension->readmeStoragePath()));
        Http::assertSent(fn ($request) => str_contains($request->url(), '/HEAD/'));
    }

    #[Test]
    public function the_readme_job_does_nothing_when_there_is_no_readme_anywhere()
    {
        $extension = Extension::factory()->create(['name' => 'laravel-mix-empty', 'repository' => null]);
        Storage::put('npmjs/laravel-mix-empty.json', json_encode(['name' => 'laravel-mix-empty']));

        FetchReadme::dispatchSync($extension);

        Storage::assertMissing($extension->readmeStoragePath());
    }
}
