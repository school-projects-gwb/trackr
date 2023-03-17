<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_create_user_valid(): void
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

    public function test_create_user_invalid(): void
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

    public function test_edit_user_valid(): void
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

    public function test_edit_user_email_invalid(): void
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
