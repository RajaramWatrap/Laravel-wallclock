<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'customer_id',
    ];

    /**
     * Get the associated payment.
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get the user who placed the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Define the polymorphic many-to-many relationship with Product.
     */
    public function products()
    {
        return $this->morphToMany(Product::class, 'productable')->withPivot('quantity');
    }

    /**
     * Get the total price of all products in the order.
     *
     * @return float
     */
    public function getTotalAttribute()
    {
        return $this->products->pluck('total')->sum();
    }
}
