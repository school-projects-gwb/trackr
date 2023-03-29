<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * Tests Store functionality
 * Requires correct seeding data from @see DatabaseSeeder
 */
class StoreTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Make sure store with correct form info can be created
     * @return void
     * @throws \Throwable
     */
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

    /**
     * Make sure store with incorrect form info cannot be created
     * @return void
     * @throws \Throwable
     */
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

    /**
     * Make sure store with correct name can be edited
     * @return void
     * @throws \Throwable
     */
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

    /**
     * Make sure store with correct address can be edited
     * @return void
     * @throws \Throwable
     */
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

    /**
     * Make sure store can be deleted
     * @return void
     * @throws \Throwable
     */
    public function testDeleteStore(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(2)
                ->visit('/store/stores')
                ->waitFor('button[name="delete"]')
                ->press('button[name="delete"]')
                ->acceptDialog()
                ->assertPathIs('/store/stores');
        });
    }
}
