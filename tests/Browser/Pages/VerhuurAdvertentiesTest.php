<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class VerhuurAdvertentiesTest extends DuskTestCase
{
    public function test_verhuuradvertenties()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->rodin())
                ->visit('/verhuuradvertenties')
                ->assertSee('VerhuurAdvertenties');
        });
    }
}
