<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LandingpageTest extends DuskTestCase
{
    public function test_landingpagetest()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->rodin())
                ->visit('/mediamarkt')
                ->assertSee('review');
        });
    }
}
