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
        'pickup_id',
        'carrier_id',
        'webstore_id',
        'created_at',
        'updated_at',
    ];

    public function  address(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }

    public function carrier(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Carrier::class, 'carrier_id', 'id');
    }

    public function webstore(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Webstore::class, 'webstore_id', 'id');
    }

    public function ShipmentStatuses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ShipmentStatus::class);
    }

    public function pickup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pickup::class, 'pickup_id', 'id');
    }

    public function scopeGenerateShipmentNumber(){
        $latestShipmentId = $this->latest()->first()->pluck('id');
        if($latestShipmentId){
            $shipmentNumber = '#'.str_pad($latestShipmentId[0] + 1, 8, "0", STR_PAD_LEFT);
        } else {
            $shipmentNumber = '#' . str_pad(1, 8, "0", STR_PAD_LEFT);
        }
        return $shipmentNumber;
    }
}
