<?php

namespace Tests\Unit;

use App\Documentation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DocumentationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->documentation = new Documentation();
    }

    /** @test */
    public function it_can_determine_the_path()
    {
        $this->assertEquals('1.1/test-page.md', $this->documentation->path('1.1', 'test-page'));
    }

    /** @test */
    public function it_can_retrieve_the_latest_release()
    {
        config(['documentation.latest_release' => '1.2.99']);

        $release = $this->documentation->latestRelease();

        $this->assertEquals('1.2.99', $release);
    }

    /** @test */
    public function if_there_is_no_latest_release_version_specified_we_will_fall_back_to_the_default_version()
    {
        config(['documentation.latest_release' => null]);
        config(['documentation.versions' => [
            '1.0',
        ]]);

        $release = $this->documentation->latestRelease();

        $this->assertEquals('1.0', $release);
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
        $this->assertEquals([
            '3.0',
            '2.0',
            '1.0',
        ], $versions->toArray());
    }

    /** @test */
    public function it_can_retrieve_the_default_documentation_version()
    {
        config(['documentation.versions' => [
            '3.0',
            '2.0',
            '1.0',
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
    public function if_a_default_version_is_configured_that_does_not_exist_it_will_fallback_to_the_latest_available_version()
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

    /** @test */
    public function it_can_retrieve_the_default_documentation_page()
    {
        config(['documentation.default_page' => 'test-page']);

        $this->assertEquals('test-page', $this->documentation->defaultPage());
    }

    /** @test */
    public function it_can_retrieve_the_default_documentation_start_page()
    {
        config(['documentation.versions' => [
            '1.0',
        ]]);
        config(['documentation.default_page' => 'test-page']);

        $this->assertEquals('/docs/1.0/test-page', $this->documentation->defaultStartPage());
    }

    /** @test */
    public function it_can_determine_if_a_page_has_been_excluded()
    {
        config(['documentation.excluded_pages' => 'readme']);

        $this->assertTrue($this->documentation->isExcludedPage('readme'));
        $this->assertTrue($this->documentation->isExcludedPage('README'));
        $this->assertTrue($this->documentation->isExcludedPage('ReadMe'));
    }

    /** @test */
    public function it_can_retrieve_the_index_path()
    {
        config(['documentation.table_of_contents' => 'test-table-of-contents']);

        $this->assertEquals('test-version/test-table-of-contents.md', $this->documentation->getIndexPath('test-version'));
    }

    /** @test */
    public function the_table_of_contents_page_is_always_excluded_as_a_standalone_page()
    {
        config(['documentation.table_of_contents' => 'test-table-of-contents']);

        $this->assertTrue($this->documentation->isExcludedPage('test-table-of-contents'));
    }

    /** @test */
    public function it_can_replace_a_version_placeholder_in_links()
    {
        tap($this->documentation->replaceVersion('1.1', '/docs/{{version}}/installation'), function ($string) {
            $this->assertEquals('/docs/1.1/installation', $string);
        });
    }

    /** @test */
    public function it_can_replace_a_link_to_a_full_url()
    {
        tap($this->documentation->replaceLinksToFullUrl('[Installation](/docs/1.1/installation)'), function ($string) {
            $this->assertEquals('[Installation]('.config('app.url').'/docs/1.1/installation)', $string);
        });
    }

    /** @test */
    public function it_can_retrieve_the_documentation_index_page()
    {
        Storage::fake('docs');
        Storage::disk('docs')->put('version999/test-index.md', '# index');
        config(['documentation.table_of_contents' => 'test-index']);

        $this->assertEquals('<h1>index</h1>', $this->documentation->getIndex('version999'));
    }

    /** @test */
    public function it_can_retrieve_the_documentation_index_page_and_it_has_full_urls()
    {
        Storage::fake('docs');
        Storage::disk('docs')->put('version999/index.md', '[Installation](/docs/{{version}}/installation)');

        $this->assertEquals('<p><a href="'.config('app.url').'/docs/version999/installation">Installation</a></p>', $this->documentation->getIndex('version999'));
    }

    /** @test */
    public function it_can_determine_if_a_page_exists()
    {
        Storage::fake('docs');
        config(['documentation.versions' => [
            '1.0',
        ]]);

        $this->assertFalse($this->documentation->pageExists('1.0', 'test-page'));

        Storage::disk('docs')->put('1.0/test-page.md', 'contents');
        $this->assertTrue($this->documentation->pageExists('1.0', 'test-page'));

        config(['documentation.excluded_pages' => 'test-page']);
        $this->assertFalse($this->documentation->pageExists('1.0', 'test-page'));
    }

    /** @test */
    public function a_page_that_exists_on_file_but_is_not_a_valid_version_is_considered_to_be_non_existent()
    {
        Storage::fake('docs');
        Storage::disk('docs')->put('1.0/test-page.md', 'contents');
        config(['documentation.versions' => [
            'some-other-version',
        ]]);

        $this->assertFalse($this->documentation->pageExists('1.0', 'test-page'));
    }

    /** @test */
    public function it_can_retrieve_the_url_of_a_page()
    {
        $this->assertEquals(config('app.url').'/docs/1.0/test-page', $this->documentation->url('1.0', 'test-page'));
    }

    /** @test */
    public function it_can_retrieve_the_canonical_url_for_a_page()
    {
        $this->assertNull($this->documentation->canonicalUrl('test-page'));

        Storage::fake('docs');
        Storage::disk('docs')->put('1.0/test-page.md', 'contents');
        config(['documentation.versions' => [
            '1.0',
        ]]);

        $this->assertEquals(config('app.url').'/docs/1.0/test-page', $this->documentation->canonicalUrl('test-page'));
    }

    /** @test */
    public function it_can_determine_in_which_versions_a_page_exists()
    {
        Storage::fake('docs');

        $this->assertEquals([], $this->documentation->pageExistsInVersions('non-existent-page'));

        Storage::disk('docs')->put('1.0/test-page.md', 'contents');
        Storage::disk('docs')->put('2.0/test-page.md', 'contents');
        Storage::disk('docs')->put('master/test-page.md', 'contents');
        config(['documentation.versions' => [
            'master',
            '4.0',
            '3.0',
            '2.0',
            '1.0',
        ]]);

        $this->assertEquals([
            'master' => config('app.url').'/docs/master/test-page',
            '2.0' => config('app.url').'/docs/2.0/test-page',
            '1.0' => config('app.url').'/docs/1.0/test-page',
        ], $this->documentation->pageExistsInVersions('test-page'));
    }
}
