<?php

namespace Tests\Browser;

use App\Enums\ShipmentStatusEnum;
use App\Models\Shipment;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * Tests all label creation functionality
 * Requires correct seeding data from @see DatabaseSeeder
 */
class CreateLabelTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Make sure selecting shipment with latest status set to Registered, selecting it and
     * clicking on the label creation button redirects to label creation form.
     * @return void
     * @throws \Throwable
     */
    public function testCreateLabelsCreateFormValid(): void
    {
        $shipment = $this->getNewShipment();
        $this->assertInstanceOf(Shipment::class, $shipment);
        $this->assertDatabaseHas('shipments', [
            'weight' => '199999'
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(2)
                ->visit('/store/shipments')
                ->select('status', 'registered')
                ->press('apply-filters')
                ->assertPathIs('/store/shipments')
                ->check('input[name="shipment_id[]"]:first-of-type')
                ->click('button[value="label"]')
                ->assertPathIs('/store/labels/createForm')
                ->assertSee('PostNL');
        });
    }

    /**
     * Make sure selecting shipment with latest status NOT set to Registered, selecting it and
     * clicking on the label creation button redirects to error page.
     * @return void
     * @throws \Throwable
     */
    public function testCreateLabelsCreateFormInvalid(): void
    {
        $this->browse(function (Browser $browser) {
            $trackingId = Shipment::whereNotNull('tracking_number')
                ->orderBy('id')
                ->value('tracking_number');

            $browser->loginAs(2)
                ->visit('/store/shipments')
                ->type('zoektermen', $trackingId)
                ->press('apply-filters')
                ->assertPathIs('/store/shipments')
                ->check('input[name="shipment_id[]"]:first-of-type')
                ->click('button[value="label"]')
                ->assertPathIs('/store/labels/createForm')
                ->assertDontSee('PostNL');
        });
    }

    /**
     * Make sure label creation with correct form info works for shipment
     * with latest status set to Registered
     * and correctly updates the status and redirects back to overview page.
     * @return void
     * @throws \Throwable
     */
    public function testCreateLabelsValid(): void
    {
        $shipment = $this->getNewShipment();
        $this->assertInstanceOf(Shipment::class, $shipment);
        $this->assertDatabaseHas('shipments', [
            'weight' => '199999'
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(2)
                ->visit('/store/shipments')
                ->select('status', 'registered')
                ->press('apply-filters')
                ->assertPathIs('/store/shipments')
                ->check('input[name="shipment_id[]"]:first-of-type')
                ->click('button[value="label"]')
                ->assertPathIs('/store/labels/createForm')
                ->assertSee('PostNL')
                ->radio('carrier_id', '1')
                ->press('submit')
                ->assertPathIs('/store/shipments');
        });
    }

    /**
     * Make sure label creation with incorrect form info doesn't work for shipment
     * with the latest status set to Registered
     * and redirects back to label creation form page.
     * @return void
     * @throws \Throwable
     */
    public function testCreateLabelsInvalid(): void
    {
        $shipment = $this->getNewShipment();
        $this->assertInstanceOf(Shipment::class, $shipment);
        $this->assertDatabaseHas('shipments', [
            'weight' => '199999'
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(2)
                ->visit('/store/shipments')
                ->select('status', 'registered')
                ->press('apply-filters')
                ->assertPathIs('/store/shipments')
                ->check('input[name="shipment_id[]"]:first-of-type')
                ->click('button[value="label"]')
                ->assertPathIs('/store/labels/createForm')
                ->assertSee('PostNL')
                ->press('submit')
                ->assertPathIs('/store/labels/createForm');
        });
    }

    /**
     * Create new shipment with status set to Registered
     * Distinction created by setting weight to specific value
     * @return Shipment
     */
    private function getNewShipment() {
        $shipment = Shipment::create([
            'weight' => '199999',
            'address_id' => 2,
            'webstore_id' => 1,
        ]);

        $registeredStatus = $shipment->shipmentStatuses()
            ->where('status', ShipmentStatusEnum::Registered)
            ->latest()
            ->first();

        $shipment->ShipmentStatuses()->saveMany([$registeredStatus]);

        $shipment->save();

        return $shipment;
    }
}
