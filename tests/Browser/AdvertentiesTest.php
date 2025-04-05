<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class AdvertentiesTest extends DuskTestCase
{
    public function test_advertentie_overzicht()
    {
        $this->browse(function (Browser $browser) {
            $user = User::firstOrCreate(
                ['email' => 'rodin@example.com'],
                [
                    'name' => 'Rodin',
                    'password' => bcrypt('password4'),
                    'role' => 'admin',
                    'email_verified_at' => now()
                ]
            );

            $browser->loginAs($user)
                ->visit('/advertenties')
                ->screenshot('advertenties_page')
                ->assertSee('📢 ' . __('adverts.advertentie')); // Gebruik de volledige tekst inclusief emoji
        });
    }
}
