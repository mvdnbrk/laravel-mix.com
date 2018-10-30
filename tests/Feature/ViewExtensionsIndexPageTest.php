<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewExtensionsIndexPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_the_extensions_index_page()
    {
        $response = $this->get('/extensions');

        $response->assertOk();
        $response->assertViewIs('extensions.index');
    }
}
