<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class address extends Model
{
    protected $fillable = [
        'user_id',
        'recipient_name',
        'phone',
        'address_detail',
        'district',
        'city',
        'province',
        'postal_code',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
