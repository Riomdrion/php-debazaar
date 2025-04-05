<?php


namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LandingpageTest extends DuskTestCase
{
    use DatabaseMigrations;
    public function test_bedrijf_landingpage_toont_componenten()
    {
        $user = User::factory()->create(['is_company' => true]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/bedrijf/landingpage')
                ->assertSee('Uitgelichte advertenties');
        });
    }

}
