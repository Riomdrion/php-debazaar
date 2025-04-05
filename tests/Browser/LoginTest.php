<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    public function test_user_can_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'rodin@example.com')
                ->type('password', 'password4')
                ->click('@login-button')
                ->assertPathIs('/dashboard');

        });
    }
}
