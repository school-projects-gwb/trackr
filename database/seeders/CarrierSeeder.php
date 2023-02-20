<?php

namespace Database\Seeders;

use App\Models\Carrier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Carrier::create(['name' => 'dhl']);
        Carrier::create(['name' => 'postnl']);
        Carrier::create(['name' => 'dpd']);
    }
}
