<?php

namespace Tests\Console;

use App\Jobs\FetchPackageMetaDataFromNpmJsRegistry;
use App\Models\Extension;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class MakeExtensionCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_make_a_new_extension()
    {
        Bus::fake();
        $this->artisan('extension:make', [
            'name' => 'test-extension',
        ])
            ->expectsOutput('Extension added successfully!')
            ->assertExitCode(0);

        Bus::assertDispatched(FetchPackageMetaDataFromNpmJsRegistry::class, function ($job) {
            return $job->name === 'test-extension';
        });

        $this->assertCount(1, Extension::all());
        tap(Extension::first(), function ($extension) {
            $this->assertEquals('test-extension', $extension->name);
        });
    }

    /** @test */
    public function name_is_unique()
    {
        Extension::factory()->create(['name' => 'test-extension']);

        $this->artisan('extension:make', [
            'name' => 'test-extension',
        ])
            ->expectsOutput('This extension already exists.')
            ->assertExitCode(1);

        $this->assertCount(1, Extension::all());
    }
}
