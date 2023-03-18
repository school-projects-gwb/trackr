<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * Tests Registration functionality
 * Requires correct seeding data from @see DatabaseSeeder
 */
class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Makes sure account can be registered with correct form input information
     * @return void
     * @throws \Throwable
     */
    public function testRegisterValid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'Firstname Lastname')
                ->type('email', 'testEmailCustomer@trackr.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->press('submit')
                ->assertPathIs('/dashboard');

            $this->assertDatabaseHas('users', [
                'email' => 'testEmailCustomer@trackr.com',
            ]);
        });
    }

    /**
     * Makes sure account cannot be registered with incorrect form input information
     * @return void
     * @throws \Throwable
     */
    public function testRegisterInvalid(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'InvalidRecord')
                ->type('email', 'admin@trackr.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->press('submit')
                ->assertPathIs('/register');

            $this->assertDatabaseMissing('users', [
                'name' => 'InvalidRecord',
            ]);
        });
    }
}
