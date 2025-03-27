<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelProduct extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'title',
        'description',
        'price',
        'stock',
        'status',
    ];

    public function images()
    {
        return $this->morphMany(\App\Models\Image::class, 'imageable');
    }

    public function carts()
    {
        return $this->morphedByMany(\App\Models\Cart::class, 'productable')->withPivot('quantity');
    }

    public function orders()
    {
        return $this->morphedByMany(\App\Models\Order::class, 'productable')->withPivot('quantity');
    }
}
