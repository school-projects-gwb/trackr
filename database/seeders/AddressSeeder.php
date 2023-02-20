<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Address::create([
            'first_name' => 'Testy',
            'last_name' => 'van der Test',
            'street_name' => 'testweg',
            'house_number' => '295',
            'postal_code' => '2711 HV',
            'city' => 'Testerdam',
            'country' => 'the Netherlands'
        ]);
    }
}
