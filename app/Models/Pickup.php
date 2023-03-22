<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    use HasFactory;

    protected $dates = [
        'pickup_moment',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'pickup_moment',
        'carrier_id',
        'webstore_id',
        'created_at',
        'updated_at',
    ];

    public function shipments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    public function carrier()
    {
        return $this->hasOne(Carrier::class, 'id', 'carrier_id');
    }

    public function webstore()
    {
        return $this->hasOne(Webstore::class, 'id', 'webstore_id');
    }
}
