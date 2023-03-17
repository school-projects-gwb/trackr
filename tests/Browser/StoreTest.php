<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class StoreTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateStoreValid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(2)
                ->visit('/store/stores/create')
                ->type('name', 'StoreName')
                ->type('first_name', 'Firstname')
                ->type('last_name', 'LastName')
                ->type('street_name', 'Street')
                ->type('house_number', '13')
                ->type('postal_code', '4444 KF')
                ->type('city', 'City')
                ->type('country', 'Country')
                ->press('submit')
                ->assertPathIs('/store/stores');

            $this->assertDatabaseHas('webstores', [
                'name' => 'StoreName',
            ]);

            $this->assertDatabaseHas('addresses', [
                'postal_code' => '4444 KF',
            ]);
        });
    }

    public function testCreateStoreInvalid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(2)
                ->visit('/store/stores/create')
                ->press('submit')
                ->assertPathIs('/store/stores/create');

            $this->assertDatabaseMissing('webstores', [
                'name' => 'StoreName',
            ]);

            $this->assertDatabaseMissing('addresses', [
                'postal_code' => '4444 KF',
            ]);
        });
    }

    public function testEditStoreNameValid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(2)
                ->visit('/store/stores/edit/1')
                ->type('name', 'StoreNameNew')
                ->press('submit-name')
                ->assertPathIs('/store/stores');

            $this->assertDatabaseHas('webstores', [
                'name' => 'StoreNameNew',
            ]);
        });
    }

    public function testEditStoreAddressValid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(2)
                ->visit('/store/stores/edit/1')
                ->type('postal_code', '4433 OP')
                ->press('submit-address')
                ->assertPathIs('/store/stores');

            $this->assertDatabaseHas('addresses', [
                'postal_code' => '4433 OP',
            ]);
        });
    }
}
