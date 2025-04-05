<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VerhuurAdvertentiesTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_user_can_create_verhuuradvertentie()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/verhuuradvertenties/create')
                ->type('title', 'Partytent')
                ->type('description', '3x6m')
                ->type('price_per_day', '15')
                ->press('Opslaan')
                ->assertPathIs('/verhuuradvertenties')
                ->assertSee('Partytent');
        });
    }
}
