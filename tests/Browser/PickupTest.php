<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Carbon;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * Tests Shipment Pickup functionality
 * Requires correct seeding data from @see DatabaseSeeder
 */
class PickupTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreatePickupValid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(2)
                ->visit('/store/pickups/create')
                ->keys('input[name=pickup_datetime]', Carbon::now()->addDays(5))
                ->check('input[name="shipment_id[]"]:first-of-type')
                ->press('submit')
                ->assertPathIs('/store/pickups');
        });
    }

    public function testCreatePickupInvalid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(2)
                ->visit('/store/pickups/create')
                ->keys('input[name=pickup_datetime]', '21/01/2023 14:00')
                ->press('submit')
                ->assertPathIs('/store/pickups/create');
        });
    }

    public function testCreatePickupDateInvalid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(2)
                ->visit('/store/pickups/create')
                ->check('input[name="shipment_id[]"]:first-of-type')
                ->press('submit')
                ->assertPathIs('/store/pickups/create');
        });
    }
}
