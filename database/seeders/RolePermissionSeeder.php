<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $storeAccess = Permission::create(['name' => 'access store']);
        $storeRead = Permission::create(['name' => 'write store']);
        $storeWrite = Permission::create(['name' => 'read store']);

        // Manages store owners
        Role::create(['name' => 'SuperAdmin']);
        // Stores
        $storeOwner = Role::create(['name' => 'StoreOwner']);
        $storeOwner->givePermissionTo($storeAccess);

        $storeAdmin = Role::create(['name' => 'StoreAdmin']);
        $storeAdmin->givePermissionTo($storeAccess);
        $storeAdmin->givePermissionTo($storeRead);
        $storeAdmin->givePermissionTo($storeWrite);

        $storePacker = Role::create(['name' => 'StorePacker']);
        $storeAdmin->givePermissionTo($storeAccess);
        $storePacker->givePermissionTo($storeRead);

        // Store customers
        Role::create(['name' => 'Customer']);
    }
}
