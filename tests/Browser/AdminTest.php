<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * Tests all SuperAdmin functionality
 * Requires correct seeding data from @see DatabaseSeeder
 */
class AdminTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Make sure creation user with correct form info fails and redirects back to overview.
     * @return void
     * @throws \Throwable
     */
    public function testCreateUserValid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/admin/users/create')
                ->type('name', 'Firstname Lastname')
                ->type('email', 'newEmail@trackr.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->press('submit')
                ->assertPathIs('/admin/users');

            $this->assertDatabaseHas('users', [
                'email' => 'newEmail@trackr.com',
            ]);
        });
    }

    /**
     * Make sure creation user with incorrect form info fails and redirects back to form page.
     * @return void
     * @throws \Throwable
     */
    public function testCreateUserInvalid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/admin/users/create')
                ->type('name', 'Firstname Lastname')
                ->type('email', 'admin@trackr.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->press('submit')
                ->assertPathIs('/admin/users/create');
        });
    }

    /**
     * Make sure editing user with correct form info works and redirects back to overview page.
     * @return void
     * @throws \Throwable
     */
    public function testEditUserValid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/admin/users/edit/2')
                ->type('name', 'Store Owner Updated')
                ->press('submit')
                ->assertPathIs('/admin/users');

            $this->assertDatabaseHas('users', [
                'name' => 'Store Owner Updated',
            ]);
        });
    }

    /**
     * Make sure editing user with incorrect email fails and redirects back to form page.
     * @return void
     * @throws \Throwable
     */
    public function testEditUserEmailInvalid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/admin/users/edit/2')
                ->type('email', 'admin@trackr.com')
                ->press('submit')
                ->assertPathIs('/admin/users/edit/2');

            $this->assertDatabaseHas('users', [
                'email' => 'owner@store.com',
            ]);
        });
    }
}
