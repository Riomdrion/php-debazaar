<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdvertentiesTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_user_can_create_advertentie()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/advertenties/create')
                ->type('title', 'Kettingzaag')
                ->type('description', 'Zo goed als nieuw')
                ->type('price', '25')
                ->press('Opslaan')
                ->assertPathIs('/advertenties')
                ->assertSee('Kettingzaag');
        });
    }

    public function test_user_cannot_create_more_than_four_ads()
    {
        $user = User::factory()->create();

        // Seed met 4 advertenties
        \App\Models\Advertentie::factory()->count(4)->create(['user_id' => $user->id]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/advertenties/create')
                ->assertSee('Je hebt het maximum aantal advertenties bereikt');
        });
    }

}
