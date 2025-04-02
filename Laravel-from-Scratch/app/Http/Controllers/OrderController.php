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
    // Check if the user is authenticated
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'If you are already registered, please login to proceed. Otherwise, please register and login.');
    }

    $user = $request->user();
    $cart = $this->cartService->getFromCookie();

    if (!$cart || $cart->products->isEmpty()) {
        return redirect()->route('orders.create')->withErrors('Your cart is empty.');
    }

    // Validate Address
    $request->validate([
        'address' => 'required|string|max:255',
    ]);

    // Create Order
    $order = $user->orders()->create([
        'status' => 'pending',
        'address' => $request->address,
    ]);

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
