<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ViewDocumentationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['documentation.versions.published' => [
            '9.9',
        ]]);
    }

    /** @test */
    public function a_request_to_the_documentation_index_should_redirect_to_the_latest_version()
    {
        $response = $this->get('/docs');

        $response->assertStatus(Response::HTTP_SEE_OTHER);
        $response->assertRedirect('/docs/9.9');
    }

    /** @test */
    public function a_request_to_a_specific_page_without_a_version_number_should_redirect_to_the_lastest_version_of_that_page_in_the_documentation()
    {
        $response = $this->get('/docs/example-page');

        $response->assertStatus(Response::HTTP_SEE_OTHER);
        $response->assertRedirect('/docs/9.9/example-page');
    }

    /** @test */
    public function a_request_to_a_specific_version_without_a_specific_page_should_redirect_to_the_default_page_of_that_version()
    {
        config(['documentation.pages.default' => 'test-default-page']);

        $response = $this->get('/docs/9.9');

        $response->assertStatus(Response::HTTP_SEE_OTHER);
        $response->assertRedirect('/docs/9.9/test-default-page');
    }

    /** @test */
    public function view_a_documentation_page()
    {
        $this->withoutMix();
        Storage::fake('docs');
        Storage::disk('docs')->put('9.9/test-page.md', file_get_contents(__DIR__.'/../fixtures/markdown.md'));

        $this->assertTrue(Storage::disk('docs')->exists('9.9/test-page.md'));

        $response = $this->get('/docs/9.9/test-page');

        $response->assertOk();
        $response->assertViewIs('documentation');
        $response->assertSee('<h1>Test title</h1>', false);
    }

    /** @test */
    public function a_request_to_a_non_exisiting_page_should_return_a_404()
    {
        Storage::fake('docs');

        $response = $this->get('/docs/9.9/page-does-not-exist');

        $response->assertNotFound();
    }

    /** @test */
    public function a_request_to_an_excluded_documentation_page_should_return_a_404()
    {
        Storage::fake('docs');
        Storage::disk('docs')->put('9.9/excluded.md', '# Excluded page');
        config(['documentation.pages.exclude' => 'excluded']);

        $this->assertTrue(Storage::disk('docs')->exists('9.9/excluded.md'));

        $response = $this->get('/docs/9.9/excluded');

        $response->assertNotFound();
    }
}
