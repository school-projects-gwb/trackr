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
    ];

    protected $fillable = [
        'token',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function isValid(string $token): bool{
        $tokenData = explode(':', $token);
        $userToken = $this::where('id', $tokenData[0])->get()->first();
        return (isset($userToken)) && Hash::check($tokenData[1], $userToken->token);
    }
}
