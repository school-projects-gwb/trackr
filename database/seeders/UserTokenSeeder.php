<?php

namespace Database\Seeders;

use App\Models\UserToken;
use Illuminate\Database\Seeder;

class UserTokenSeeder extends Seeder
{
    public function run()
    {
        UserToken::create([
            'token' => '$2y$10$OT95HODGotgYsEH9uJYOtudtY3xQ.f4LZ0pCiJBs7cWKu7V0yNVzO', //670511b9d8e2a87093c7f50d1a07bb75e0412f9f2ef406205acc66628498f231
            'user_id' => 1
        ]);
    }
}
