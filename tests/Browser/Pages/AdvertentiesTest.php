<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdvertentiesTest extends DuskTestCase
{
    public function test_advertentie_overzicht()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->rodin())
                ->visit('/advertenties')
                ->assertSee('Advertenties');
        });
    }
}
