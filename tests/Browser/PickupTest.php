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
                ->type('pickup_datetime', now()->addDays(4)->setTime(13, 0)->format('Y-m-d\TH:i'))
                ->check('input[name="shipment_id[]"]:first-of-type')
                ->press('submit')
                ->assertPathIs('/store/pickups');
        });
    }

    public function testCreatePickupDateInvalid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(2)
                ->visit('/store/pickups/create')
                ->type('pickup_datetime', now()->setTime(14, 0)->format('Y-m-d\TH:i'))
                ->check('input[name="shipment_id[]"]:first-of-type')
                ->press('submit')
                ->assertSee('De ophaal datum moet minimaal 2 dagen van de voren voor 15:00 ingepland zijn')
                ->assertPathIs('/store/pickups/create');
        });
    }
}
