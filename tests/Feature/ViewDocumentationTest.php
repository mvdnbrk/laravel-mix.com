<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class ViewDocumentationTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        config(['documentation.versions' => [
            '9.9',
        ]]);
    }

    /** @test */
    public function a_request_to_the_documentation_index_should_redirect_to_the_latest_version()
    {
        $response = $this->get('/docs');

        $response->assertStatus(301);
        $response->assertRedirect('/docs/9.9');
    }

    /** @test */
    public function a_request_to_a_specific_page_without_a_version_number_should_redirect_to_the_lastest_version_of_that_page_in_the_documentation()
    {
        $response = $this->get('/docs/example-page');

        $response->assertStatus(301);
        $response->assertRedirect('/docs/9.9/example-page');
    }

    /** @test */
    public function a_request_to_a_specific_version_without_a_specific_page_should_redirect_to_the_installation_page_of_that_version()
    {
        config(['documentation.default_page' => 'test-default-page']);

        $response = $this->get('/docs/9.9');

        $response->assertStatus(301);
        $response->assertRedirect('/docs/9.9/test-default-page');
    }

    /** @test */
    public function view_a_documentation_page()
    {
        Storage::fake('docs');
        Storage::disk('docs')->put('9.9/test-page.md', '# Test title');

        $this->assertTrue(Storage::disk('docs')->exists('9.9/test-page.md'));

        $response = $this->get('/docs/9.9/test-page');

        $response->assertOk();
        $response->assertViewIs('documentation');
        $response->assertSee('<h1>Test title</h1>');
    }

    /** @test */
    public function a_request_to_a_non_exisiting_page_should_return_a_404()
    {
        Storage::fake('docs');

        $response = $this->get('/docs/9.9/page-does-not_exist');

        $response->assertNotFound();
    }
}