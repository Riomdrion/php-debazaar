<?php

namespace Tests\Browser;

use App\Models\VerhuurAdvertentie;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class VerhuurAdvertentiesTest extends DuskTestCase
{
    public function test_user_can_see_dashboard()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->rodin())
                ->visit('/dashboard')
                ->pause(500)
                ->assertSee('Dashboard');
        });
    }

    public function test_index_page_shows_verhuuradvertenties()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->rodin())
                ->visit('/verhuuradvertenties') // Zorg dat deze route klopt
                ->pause(500)
                ->assertSee('📢 '.__('adverts.Verhuur_Advertenties')); // Pas aan naar jouw index-paginatitel
        });
    }

    public function test_create_page_is_accessible()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->rodin())
                ->visit('/verhuuradvertenties/create')
                ->pause(500)
                ->assertSee( '📝 '.__('adverts.Nieuwe_Verhuuradvertentie'));
        });
    }

    public function test_user_can_create_advertentie()
    {
        VerhuurAdvertentie::truncate();
        $id = VerhuurAdvertentie::max('id') + 1;
        $this->browse(function (Browser $browser) use ($id) {
            $browser->loginAs($this->rodin())
                ->visit('/verhuuradvertenties/create')
                ->pause(500)
                ->type('@titel', 'Test Verhuur')
                ->type('@beschrijving', 'Een test advertentie beschrijving')
                ->type('@dagprijs', '12.34')
                ->type('@borg', '1234')
                ->type('@vervangingswaarde', '12')
                ->check('@is_actief', '1')
                ->press('@plaats_verhuuradvertentie')
                ->pause(500)
                ->assertPathIs('/verhuuradvertenties/'.$id)
                ->assertSee('Test Verhuur');
        });
    }

    public function test_user_can_edit_advertentie()
    {
        $id = VerhuurAdvertentie::whereNotNull('id')->first()->id;
        $this->browse(function (Browser $browser) use ($id) {
            $browser->loginAs($this->rodin())
                ->visit("/verhuuradvertenties/{$id}/edit")
                ->type('@titel', 'Bijgewerkte Titel')
                ->press('@advertentie-bewerken-knop')
                ->assertPathIs('/verhuuradvertenties/'.$id)
                ->assertSee('Bijgewerkte Titel');
        });
    }

    public function test_user_can_delete_advertentie()
    {
        $id = VerhuurAdvertentie::whereNotNull('id')->first()->id;
        $this->browse(function (Browser $browser) use ($id) {
            $browser->loginAs($this->rodin())
                ->visit('/verhuuradvertenties/' . $id)
                ->press("@delete-button") // Zorg dat je Dusk selector instelt in Blade
                ->pause(500)
                ->press('Ok')
                ->pause(500) // optioneel: geef tijd voor redirect/verversen
                ->visit('/verhuuradvertenties/' . $id)
                ->assertSee('404');
        });
    }
}
