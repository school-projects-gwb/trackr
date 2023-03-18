<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * Tests Store User functionality
 * Requires correct seeding data from @see DatabaseSeeder
 */
class StoreUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Make sure user with correct info can be created
     * @return void
     * @throws \Throwable
     */
    public function testCreateUserValid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(2)
                ->visit('/store/users/create')
                ->type('name', 'Firstname Lastname')
                ->type('email', 'storeUser@trackr.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->radio('role_id', '3')
                ->check('input[name="store_id[]"][value="1"]')
                ->press('submit')
                ->assertPathIs('/store/users');

            $this->assertDatabaseHas('users', [
                'email' => 'storeUser@trackr.com',
            ]);
        });
    }

    /**
     * Make sure user with incorrect info cannot be created
     * @return void
     * @throws \Throwable
     */
    public function testCreateUserInvalid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(2)
                ->visit('/store/users/create')
                ->type('name', 'Firstname Lastname')
                ->type('email', 'storeUser@trackr.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'passwordNoMatch')
                ->radio('role_id', '3')
                ->check('input[name="store_id[]"][value="1"]')
                ->press('submit')
                ->assertPathIs('/store/users/create');
        });
    }

    /**
     * Make sure user with correct info can be edited
     * @return void
     * @throws \Throwable
     */
    public function testEditUserValid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(2)
                ->visit('/store/users/edit/3')
                ->type('name', 'Store Admin Updated')
                ->press('submit')
                ->assertPathIs('/store/users');

            $this->assertDatabaseHas('users', [
                'name' => 'Store Admin Updated',
            ]);
        });
    }

    /**
     * Make sure user with incorrect info cannot be edited
     * @return void
     * @throws \Throwable
     */
    public function testEditUserInvalid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(2)
                ->visit('/store/users/edit/3')
                ->type('email', 'admin@trackr.com')
                ->press('submit')
                ->assertPathIs('/store/users/edit/3');

            $this->assertDatabaseHas('users', [
                'email' => 'admin@store.com',
            ]);
        });
    }

    /**
     * Make sure user can be deleted
     * @return void
     * @throws \Throwable
     */
    public function testDeleteUser(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(2)
                ->visit('/store/users')
                ->waitFor('button[name="delete"]')
                ->press('button[name="delete"]')
                ->acceptDialog()
                ->assertPathIs('/store/users');

            $this->assertDatabaseMissing('users', [
                'id' => '3'
            ]);
        });
    }
}
