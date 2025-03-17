<?php

namespace App\Http\Controllers;

use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display the cart contents.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cart = $this->cartService->getFromCookie();

        return view('carts.index', compact('cart'));
    }
}
