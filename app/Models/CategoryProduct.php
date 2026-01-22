<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryProduct extends Model
{
    protected $fillable = ['name', 'icon'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_product_id');
    }
}

