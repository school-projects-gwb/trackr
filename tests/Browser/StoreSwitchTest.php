<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * Tests whether store can be switched
 * Requires correct seeding data from @see DatabaseSeeder
 */
class StoreSwitchTest extends DuskTestCase
{
    public function testStoreSwitchValid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(2)
                ->visit('/store/shipments')
                ->press('submit-2')
                ->assertSeeIn('#selected-store', 'MarktMedia');
        });
    }
}
