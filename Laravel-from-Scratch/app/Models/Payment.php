<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'payed_at',
        'order_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'payed_at' => 'datetime', // ✅ Corrected from `$dates` to `$casts`
    ];

    /**
     * Define the inverse relationship with Order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
