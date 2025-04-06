<?php

namespace Tests\Browser;

use App\Models\Bedrijf;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\WithFaker;

class Bedrijf_zonder_FactuurTest extends DuskTestCase
{
    use WithFaker;

    /**
     * Test that an admin user can view the "Bedrijven Zonder Factuur" page.
     *
     * @throws \Throwable
     */
    public function testNonAdminCannotViewBedrijvenZonderFactuur()
    {
        $user = User::factory()->create(['role' => 'gebruiker']);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/admin/bedrijven-zonder-factuur')
                ->screenshot('non-admin-redirect')
                // Verify we're not on the bedrijven page
                ->assertPathIsNot('/admin/bedrijven-zonder-factuur')
                // Verify we're redirected to the dashboard/home
                ->assertPathIs('/dashboard') // or whatever your dashboard route is
                // Verify the bedrijven table isn't visible
                ->assertMissing('@bedrijven-table');
        });
    }
    public function testBasicPageLoad()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/bedrijven-zonder-factuur')
                ->screenshot('basic-load')
                ->assertSee('Bedrijven Zonder Factuur')
                ->assertVisible('@bedrijven-table');
        });
    }
}
