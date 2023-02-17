<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ShipmentStatusEnum;

class ShipmentStatus extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'status',
        'shipment_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'status' => ShipmentStatusEnum::class
    ];

    public function shipment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Shipment::class,'shipment_id', 'id');
    }
}
