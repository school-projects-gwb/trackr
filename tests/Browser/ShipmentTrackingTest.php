<?php

namespace Tests\Browser;

use App\Models\Shipment;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * Tests Shipment tracking functionality
 * Requires correct seeding data from @see DatabaseSeeder
 */
class ShipmentTrackingTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Make sure tracking page shows correct shipment info
     * @return void
     * @throws \Throwable
     */
    public function testValidTrackingInfoShowsTrackingPage(): void
    {
        $trackingId = Shipment::whereNotNull('tracking_number')
            ->orderBy('id')
            ->value('tracking_number');
        $postalCode = '5555 CW';

        $this->browse(function (Browser $browser) use ($trackingId, $postalCode) {
            $browser->visit('/')
                ->type('tracking_id', $trackingId)
                ->type('postal_code', $postalCode)
                ->press('submit')
                ->assertSee($postalCode);
        });
    }

    /**
     * Make sure invalid tracking info shows not found page
     * @return void
     * @throws \Throwable
     */
    public function testInvalidTrackingInfoShowsNotfoundPage(): void
    {
        $trackingId = 'TRACKR1DHinvalidinfo';
        $postalCode = '5555 CWinvalidpostalcode';

        $this->browse(function (Browser $browser) use ($trackingId, $postalCode) {
            $browser->visit('/')
                ->type('tracking_id', $trackingId)
                ->type('postal_code', $postalCode)
                ->press('submit')
                ->assertDontSee($postalCode);
        });
    }
}
