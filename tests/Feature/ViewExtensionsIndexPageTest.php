<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ViewExtensionsIndexPageTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_view_the_extensions_index_page()
    {
        $response = $this->get('/extensions');

        $response->assertOk();
        $response->assertViewIs('extensions.index');
    }
}
