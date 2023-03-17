<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ShipmentTraceTest extends DuskTestCase
{
    use RefreshDatabase;

    public function testValidTrackingInfoShowsTrackingPage(): void
    {
        $trackingId = 'TRACKR1DH';
        $postalCode = '5555 CW';

        $this->browse(function (Browser $browser) use ($trackingId, $postalCode) {
            $browser->visit('/')
                ->type('tracking_id', $trackingId)
                ->type('postal_code', $postalCode)
                ->press('submit')
                ->assertSee($postalCode);
        });
    }

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
