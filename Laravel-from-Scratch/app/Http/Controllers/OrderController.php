<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;

        // Apply authentication middleware
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $cart = $this->cartService->getFromCookie();

        if (!$cart || $cart->products->isEmpty()) {
            return redirect()->back()->withErrors('Your Cart is Empty');
        }

        return view('orders.create', compact('cart'));
    }

    /**
     * Store a newly created order in the database.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $cart = $this->cartService->getFromCookie();

        if (!$cart || $cart->products->isEmpty()) {
            return redirect()->route('orders.create')->withErrors('Your cart is empty.');
        }

        // Create order
        $order = $user->orders()->create(['status' => 'pending']);

        // Attach cart products to order
        $cartProductsWithQuantity = $cart->products->mapWithKeys(fn ($product) => [
            $product->id => ['quantity' => $product->pivot->quantity]
        ]);

        $order->products()->attach($cartProductsWithQuantity->toArray());

        // Redirect to the payment page for the newly created order
        return redirect()->route('orders.payments.create', ['order' => $order->id]);
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }
}
