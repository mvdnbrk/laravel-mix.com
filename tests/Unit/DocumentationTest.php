<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Documentation;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DocumentationTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->documentation = new Documentation(new Filesystem());
    }

    /** @test */
    public function it_can_retrieve_a_collection_of_all_versions_of_the_documentation()
    {
        config(['documentation.versions' => [
            '3.0',
            '2.0',
            '1.0',
        ]]);

        $versions = $this->documentation->versions();

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $versions);
        $this->assertArraySubset([
            '3.0',
            '2.0',
            '1.0'
        ], $versions);
    }

    /** @test */
    public function it_can_retrieve_the_default_documentation_version()
    {
        config(['documentation.versions' => [
            '3.0',
            '2.0',
            '1.0'
        ]]);

        $defaultVersion = $this->documentation->defaultVersion();

        $this->assertEquals('3.0', $defaultVersion);
    }

    /** @test */
    public function master_is_not_considered_the_default_version()
    {
        config(['documentation.versions' => [
            'master',
            '1.0',
        ]]);

        $defaultVersion = $this->documentation->defaultVersion();

        $this->assertEquals('1.0', $defaultVersion);
    }

    /** @test */
    public function if_a_default_version_is_configured_it_retrieves_that_value_as_the_default_version()
    {
        config(['documentation.versions' => [
            '2.0',
            '1.0',
        ]]);
        config(['documentation.default_version' => '1.0']);

        $defaultVersion = $this->documentation->defaultVersion();

        $this->assertEquals('1.0', $defaultVersion);
    }

    /** @test */
    public function if_a_default_version_is_configured_that_does_not_exits_it_will_fallback_to_the_latest_available_version()
    {
        config(['documentation.versions' => [
            '2.0',
            '1.0',
        ]]);
        config(['documentation.default_version' => 'not-valid']);

        $defaultVersion = $this->documentation->defaultVersion();

        $this->assertEquals('2.0', $defaultVersion);
    }

    /** @test */
    public function it_can_detect_if_a_version_is_a_valid_version()
    {
        config(['documentation.versions' => [
            '1.0',
        ]]);

        $this->assertTrue($this->documentation->isVersion('1.0'));
        $this->assertFalse($this->documentation->isVersion('invalid-version'));
    }
}
