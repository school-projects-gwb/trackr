<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'street_name',
        'house_number',
        'postal_code',
        'city',
        'country',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function shipments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'address_user');
    }

    public function store(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Webstore::class);
    }
}
