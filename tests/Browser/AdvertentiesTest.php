<?php

namespace Tests\Browser;

use App\Models\Advertentie;
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

    /**
     * Test dat een gebruiker een nieuwe advertentie kan aanmaken.
     * werkt alleen als er minder dan 4 advertenties zijn.
     */
    public function testUserCanCreateAdvertisement()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->rodin())
                ->visit('/advertenties/create')
                ->type('titel', 'Test Advertentie')
                ->type('beschrijving', 'Beschrijving van de test advertentie')
                ->type('prijs', '12.50')
                ->click('@advertentie-aanmaken-knop')
                ->assertPathIs('/advertenties');
        });
    }

    /**
     * Test dat een gebruiker een bestaande advertentie kan bewerken.
     */
    public function testUserCanEditAdvertisement()
    {
        // haal een valide advertentie op uit de database
        $advertentie = Advertentie::first();
        $this->browse(function (Browser $browser) use ($advertentie) {
            // Veronderstel dat advertentie met id 1 bestaat voor de test.
            $browser->loginAs($this->rodin())
                ->visit('/advertenties/' . $advertentie->id . '/edit')
                ->type('titel', 'Aangepaste Advertentie')
                ->press('@advertentie-bewerken-knop')
                ->assertPathIs('/advertenties/' . $advertentie->id)
                ->assertSee('Aangepaste Advertentie');
        });
    }

    /**
     * Test dat een gebruiker de details van een advertentie kan bekijken.
     */
    public function testUserCanViewAdvertisementDetails()
    {
        $this->browse(function (Browser $browser) {
            // Veronderstel dat advertentie met id 1 bestaat.
            $browser->loginAs($this->rodin())
                ->visit('/advertenties/1')
                ->assertSee('Beschrijving');
        });
    }

    /**
     * Test dat een gebruiker een advertentie aan favorieten kan toevoegen.
     */
    public function testUserCanFavoriteAdvertisement()
    {
        $this->browse(function (Browser $browser) {
            // Veronderstel dat de 'favorite'-functionaliteit aanwezig is op de details-pagina.
            $browser->loginAs($this->rodin())
                ->visit('/advertenties/1')
                ->click('@favorite-button') // Gebruik een Dusk selector voor de favoriet-knop.
                ->assertSee('Toegevoegd aan favorieten');
        });
    }

    /**
     * Test dat een gebruiker een review kan plaatsen bij een advertentie.
     */
    public function testUserCanSubmitReview()
    {
        $this->browse(function (Browser $browser) {
            // Veronderstel dat de review-formulier op de advertentie-detailpagina staat.
            $browser->loginAs($this->rodin())
                ->visit('/advertenties/1')
                ->type('review', 'Dit is een test review.')
                ->press('Review plaatsen')
                ->assertSee('Review succesvol geplaatst');
        });
    }

    /**
     * Test dat een gebruiker advertenties kan filteren en sorteren.
     */
    public function testUserCanFilterAndSortAdvertisements()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->rodin())
                ->visit('/advertenties')
                ->select('filter', 'nieuw') // Pas deze waarde aan op basis van de beschikbare opties.
                ->select('sort', 'datum_desc') // Pas de sorteeroptie aan indien nodig.
                ->press('Filteren')
                ->assertSee('Resultaten');
        });
    }
}
