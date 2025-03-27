<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Image;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'admin_since',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'admin_since' => 'datetime',
    ];

    /**
     * Define the one-to-many relationship with Order.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    /**
     * Define the hasManyThrough relationship with Payment.
     */
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Order::class, 'customer_id');
    }

    /**
     * Define the polymorphic one-to-one relationship with Image.
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin()
    {
        return $this->admin_since != null
            && $this->admin_since->lessThanOrEqualTo(now());
    }
}
