<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class WebstoreToken extends Model
{
    use HasFactory;

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'token',
        'webstore_id',
        'created_at',
        'updated_at',
    ];

    public function webstore(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Webstore::class, 'webstore_id', 'id');
    }

    public function isValid(array $tokenData): bool
    {
        $webstoreToken = $this::where('id', $tokenData[0])->get()->first();
        return (isset($webstoreToken)) && Hash::check($tokenData[1], $webstoreToken->token);
    }
}
