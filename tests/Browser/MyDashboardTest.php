<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MyDashboardTest extends DuskTestCase
{
    /**
     * Test dat de mydashboard-pagina toegankelijk is en de basistekst toont.
     */
    public function testMyDashboardPageIsAccessible()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->rodin())
                ->visit('/mydashboard')
                ->assertSee('My Dashboard'); // Pas aan naar de exacte tekst in jouw view.
        });
    }
}
