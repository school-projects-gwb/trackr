<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webstore extends Model
{
    use HasFactory;

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'owner_id',
        'created_at',
        'updated_at',
    ];

    public function owner(){
        return $this->belongsTo(User::class, 'id', 'owner_id');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'user_webstore');
    }

    public function shipments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    public function tokens(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WebstoreToken::class);
    }

}
