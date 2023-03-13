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
        Carrier::create(['name' => 'DHL', 'shipping_cost' => '6.75']);
        Carrier::create(['name' => 'PostNL', 'shipping_cost' => '8.50']);
        Carrier::create(['name' => 'DPD', 'shipping_cost' => '5.50']);
    }
}
