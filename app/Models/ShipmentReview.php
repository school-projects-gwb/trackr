<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentReview extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'rating',
        'comment',
        'shipment_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function shipment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Shipment::class,'shipment_id', 'id');
    }
}
