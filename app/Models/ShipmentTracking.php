<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentTracking extends Model
{
    protected $table = 'shipment_trackings';

    protected $fillable = [
        'transaction_id',
        'biteship_status',
        'mapped_status',
        'note',
        'courier_link',
        'event_time',
    ];

    protected $casts = [
        'event_time' => 'datetime',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
