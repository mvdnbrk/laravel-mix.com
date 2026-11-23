<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TroubleshootingPageTest extends TestCase
{
    #[Test]
    public function the_troubleshooting_page_shows_the_common_errors()
    {
        $this->get('/troubleshooting')
            ->assertOk()
            ->assertViewIs('pages.troubleshooting')
            ->assertSee('<h1>Troubleshooting Laravel Mix 6</h1>', false)
            ->assertSee("Cannot find module 'webpack/lib/SizeFormatHelpers'", false);
    }

    #[Test]
    public function the_homepage_links_to_the_troubleshooting_page()
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('href="'.route('troubleshooting').'"', false);
    }
}
