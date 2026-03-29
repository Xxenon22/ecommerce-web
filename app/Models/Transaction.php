<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = ['user_id', 'restaurant_id', 'total_price', 'status', 'payment_method_id', 'snap_token'];
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function transactionProducts()
    {
        return $this->hasMany(TransactionProduct::class);
    }
}
