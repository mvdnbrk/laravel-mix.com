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
}
