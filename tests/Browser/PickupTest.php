<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PickupTest extends DuskTestCase
{
    /**
     * Tests Shipment Pickup functionality
     * Requires correct seeding data from @see DatabaseSeeder
     */
    public function testCreatePickupValid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(2)
                ->visit('/store/pickups/create')
                ->keys('pickup_datetime', '21/06/2023 14:00')
                ->check('input[name="shipment_id[]"][id="shipment-0"]')
                ->check('input[name="shipment_id[]"][id="shipment-1"]')
                ->press('submit')
                ->assertPathIs('/store/pickups');;
        });
    }

    public function testCreatePickupInvalid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(2)
                ->visit('/store/pickups/create')
                ->keys('pickup_datetime', '21/06/2023 14:00')
                ->press('submit')
                ->assertPathIs('/store/pickups/create');;
        });
    }
}
