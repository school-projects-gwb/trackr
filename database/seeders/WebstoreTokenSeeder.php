<?php

namespace Database\Seeders;

use App\Models\WebstoreToken;
use Illuminate\Database\Seeder;

class WebstoreTokenSeeder extends Seeder
{
    public function run()
    {
        WebstoreToken::create([
            'token' => '$2y$10$OT95HODGotgYsEH9uJYOtudtY3xQ.f4LZ0pCiJBs7cWKu7V0yNVzO', //670511b9d8e2a87093c7f50d1a07bb75e0412f9f2ef406205acc66628498f231
            'webstore_id' => 1
        ])->assignRole('StoreApi');
    }
}
