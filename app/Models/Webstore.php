<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Webstore extends Model
{
    use HasFactory, SoftDeletes;

    protected $with = ['tokens'];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'name',
        'owner_id',
        'address_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'owner_id');
    }

    public function address(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
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

    public function tableDisplayField(): string {
        return $this->name;
    }
}
