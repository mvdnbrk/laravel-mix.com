<?php

namespace Tests\Unit;

use App\Extension;
use Tests\TestCase;

class ExtensionTest extends TestCase
{
    /** @test */
    public function it_can_get_the_json_path()
    {
        $extension = factory(Extension::class)->make([
            'name' => 'laravel-mix',
        ]);

        $this->assertEquals('npmjs/laravel-mix.json', $extension->jsonStoragePath());
    }

    /** @test */
    public function it_can_get_the_readme_path()
    {
        $extension = factory(Extension::class)->make([
            'name' => 'laravel-mix',
        ]);

        $this->assertEquals('readme/laravel-mix.md', $extension->readmeStoragePath());
    }

    /** @test */
    public function it_casts_counts_to_integers()
    {
        $extension = factory(Extension::class)->make([
            'version_count' => '123',
            'weekly_download_count' => '456',
        ]);

        $this->assertSame(123, $extension->version_count);
        $this->assertSame(456, $extension->weekly_download_count);
    }
}
