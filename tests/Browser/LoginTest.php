<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * Tests Login functionality
 * Requires correct seeding data from @see DatabaseSeeder
 */
class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Make sure admin can log in
     * @return void
     * @throws \Throwable
     */
    public function testAdminLoginCorrect(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'admin@trackr.com')
                ->type('password', 'password')
                ->press('submit')
                ->assertPathIs('/admin');

            $browser->logout();
        });
    }

    /**
     * Make sure store owner can log in
     * @return void
     * @throws \Throwable
     */
    public function testStoreOwnerCorrect(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'owner@store.com')
                ->type('password', 'password')
                ->press('submit')
                ->assertPathIs('/dashboard');

            $browser->logout();
        });
    }

    /**
     * Make sure logging in with incorrect info fails
     * @return void
     * @throws \Throwable
     */
    public function testLoginIncorrect(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'admin@trackr.com')
                ->type('password', 'password_incorrect')
                ->press('submit')
                ->assertPathIs('/login');

            $browser->logout();
        });
    }
}
