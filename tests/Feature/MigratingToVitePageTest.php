<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MigratingToVitePageTest extends TestCase
{
    #[Test]
    public function the_migrating_to_vite_page_is_available()
    {
        $this->get('/migrating-to-vite')
            ->assertOk()
            ->assertViewIs('pages.migrating-to-vite')
            ->assertSee('<h1>Migrating from Mix to Vite</h1>', false)
            ->assertSee('From webpack.mix.js to vite.config.js');
    }
}
