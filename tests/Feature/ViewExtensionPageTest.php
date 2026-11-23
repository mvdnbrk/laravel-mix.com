<?php

namespace Tests\Feature;

use App\Models\Extension;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ViewExtensionPageTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_view_an_extension_page()
    {
        $extension = Extension::factory()->create([
            'slug' => 'test-extension',
        ]);

        $response = $this->get('/extensions/test-extension');

        $response->assertOk();
        $response->assertViewIs('extensions.show');
        $response->assertViewHas('extension', function ($data) use ($extension) {
            return $data->is($extension);
        });
    }

    #[Test]
    public function a_user_sees_a_404_when_requesting_a_non_existent_extension()
    {
        $response = $this->get('/extensions/does-not-exist');

        $response->assertNotFound();
    }
}
