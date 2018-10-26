<?php

namespace Tests\Feature;

use Tests\TestCase;

class ViewHomepageTest extends TestCase
{
    /** @test */
    public function a_request_to_the_homepage_should_return_a_200_status_code()
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertViewIs('welcome');
    }
}
