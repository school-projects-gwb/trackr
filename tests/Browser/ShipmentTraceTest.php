<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ShipmentTraceTest extends DuskTestCase
{
    public function test_valid_tracking_info_shows_tracking_page(): void
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

    public function test_invalid_tracking_info_shows_notfound_page(): void
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
