<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Cart extends Model
{
    use HasFactory;

    /**
     * Define the polymorphic many-to-many relationship with Product.
     */
    public function products()
    {
        return $this->morphToMany(Product::class, 'productable')->withPivot('quantity');
    }

    /**
     * Get the total price of all products in the cart.
     *
     * @return float
     */
    public function getTotalAttribute()
    {
        return $this->products->pluck('total')->sum();
    }
}
