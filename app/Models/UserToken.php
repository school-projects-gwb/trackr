<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserToken extends Model
{
    use HasFactory;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'token',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function isValid(string $token): bool{
        $tokenData = explode(':', $token);
        $userToken = $this::where('id', $tokenData[0])->get()->first();
        return (isset($userToken)) && Hash::check($tokenData[1], $userToken->token);
    }
}
