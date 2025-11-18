<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'id_category_product',
        'id_user',
        'name',
        'photo',
        'price',
        'description',
        'stock',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryProduct::class, 'id_category_product');
    }
}
