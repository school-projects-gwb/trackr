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
            'first_name' => 'Henk',
            'last_name' => 'van der Kwab',
            'street_name' => 'Rijthovenweg',
            'house_number' => '295',
            'postal_code' => '2408 HV',
            'city' => 'Alphen a/d Rijn',
            'country' => 'the Netherlands'
        ]);
    }
}
