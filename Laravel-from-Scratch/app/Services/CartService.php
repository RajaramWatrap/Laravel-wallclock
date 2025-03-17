<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Cookie;

class CartService
{
    protected $cookieName = 'cart';

    /**
     * Retrieve the cart from the cookie.
     *
     * @return \App\Models\Cart|null
     */
    public function getFromCookie()
    {
        $cartId = Cookie::get($this->cookieName);

        return Cart::find($cartId);
    }

    /**
     * Retrieve the cart from the cookie or create a new one.
     *
     * @return \App\Models\Cart
     */
    public function getFromCookieOrCreate()
    {
        $cart = $this->getFromCookie();

        return $cart ?? Cart::create();
    }

    /**
     * Create a cookie for the cart.
     *
     * @param \App\Models\Cart $cart
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    public function makeCookie(Cart $cart)
    {
        return Cookie::make($this->cookieName, $cart->id, 7 * 24 * 60);
    }

    /**
     * Count the total number of products in the cart.
     *
     * @return int
     */
    public function countProducts()
    {
        $cart = $this->getFromCookie();

        return $cart ? $cart->products->pluck('pivot.quantity')->sum() : 0;
    }
}
