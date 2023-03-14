<?php

namespace Database\Seeders;

use App\Models\Webstore;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebstoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Webstore::create([
           'name' => 'Test Store',
           'owner_id' => 2,
           'address_id' => 1
        ])->users()->attach([2, 3, 4]);
    }
}
