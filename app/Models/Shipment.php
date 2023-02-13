<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'tracking_number',
        'weight',
        'address_id',
        'carrier_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function  Address(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }

    public function Carrier(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Carrier::class, 'id', 'carrier_id');
    }

    public function ShipmentStatuses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ShipmentStatus::class);
    }
}
