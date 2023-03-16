<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolePermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(WebstoreSeeder::class);
        $this->call(WebstoreTokenSeeder::class);
        $this->call(CarrierSeeder::class);
        $this->call(ShipmentSeeder::class);
    }
}
