<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserDashboardAccessTest extends DuskTestCase
{
    use RefreshDatabase;

    public function testStoreSuperAdminMenuVisibility()
    {
        $this->browse(function (Browser $browser) {
            $visible = ['#menu-dashboard', '#menu-user-management'];
            $missing = ['#menu-pickups', '#menu-shipments', '#menu-saved-shipments', '#menu-users', '#menu-webstores', '#menu-reviews'];

            $browser->loginAs(1);
            $browser->visit('/dashboard');
            $browser->assertVisible($this->stringify($visible));
            $browser->assertMissing($this->stringify($missing));
        });
    }

    public function testStoreOwnerMenuVisibility()
    {
        $this->browse(function (Browser $browser) {
            $visible = ['#menu-dashboard', '#menu-users', '#menu-webstores', '#menu-reviews', '#menu-shipments', '#menu-pickups'];
            $missing = ['#menu-user-management', '#menu-saved-shipments'];
            $browser->loginAs(2);
            $browser->visit('/dashboard');
            $browser->assertVisible($this->stringify($visible));
            $browser->assertMissing($this->stringify($missing));
        });
    }

    public function testStoreAdminMenuVisibility()
    {
        $this->browse(function (Browser $browser) {
            $visible = ['#menu-dashboard', '#menu-shipments', '#menu-pickups'];
            $missing = ['#menu-user-management', '#menu-saved-shipments', '#menu-users', '#menu-webstores', '#menu-reviews'];

            $browser->loginAs(3);
            $browser->visit('/dashboard');
            $browser->assertVisible($this->stringify($visible));
            $browser->assertMissing($this->stringify($missing));
        });
    }

    public function testStorePackerMenuVisibility()
    {
        $this->browse(function (Browser $browser) {
            $visible = ['#menu-dashboard', '#menu-shipments', '#menu-pickups'];
            $missing = ['#menu-user-management', '#menu-saved-shipments', '#menu-users', '#menu-webstores', '#menu-reviews'];
            // Log in as a user
            $browser->loginAs(3);
            // Visit the page where the menu is located
            $browser->visit('/dashboard');
            $browser->assertVisible($this->stringify($visible));
            $browser->assertMissing($this->stringify($missing));
        });
    }

    public function testCustomerMenuVisibility()
    {
        $this->browse(function (Browser $browser) {
            $visible = ['#menu-dashboard', '#menu-saved-shipments'];
            $missing = ['#menu-user-management', '#menu-shipments', '#menu-pickups', '#menu-users', '#menu-webstores', '#menu-reviews'];
            // Log in as a user
            $browser->loginAs(5);
            // Visit the page where the menu is located
            $browser->visit('/dashboard');
            $browser->assertVisible($this->stringify($visible));
            $browser->assertMissing($this->stringify($missing));
        });
    }

    private function stringify($array) {
        return implode(',', $array);
    }
}
