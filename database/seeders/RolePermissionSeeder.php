<?php

namespace Database\Seeders;

use GuzzleHttp\Promise\Create;
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
        $apiShipmentCreate = Permission::create(['name' => 'api shipment create', 'guard_name' => 'api']);
        $apiShipmentStatusUpdate = Permission::create(['name' => 'api shipment status update', 'guard_name' => 'api']);

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

        $storeApi = Role::create(['name' => 'StoreApi', 'guard_name' => 'api']);
        $storeApi->givePermissionTo($apiShipmentCreate);
        $storeApi->givePermissionTo($apiShipmentStatusUpdate);

        $storeCarrierApi = Role::create(['name' => 'StoreCarrierApi', 'guard_name' => 'api']);
        $storeCarrierApi->givePermissionTo($apiShipmentStatusUpdate);

        // Store customers
        Role::create(['name' => 'Customer']);
    }
}
