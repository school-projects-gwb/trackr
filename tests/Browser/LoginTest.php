<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use RefreshDatabase;

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

    public function testStoreUserCorrect(): void
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
