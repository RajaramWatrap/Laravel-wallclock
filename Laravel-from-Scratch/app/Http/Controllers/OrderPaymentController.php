<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\Request;

class OrderPaymentController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;

        // Apply authentication middleware
    }

    /**
     * Show the payment form for a given order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function create(Order $order)
    {
        return view('payments.create', compact('order'));
    }

    /**
     * Process the payment for the given order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Order $order)
    {
        // Ensure cart exists before clearing
        $cart = $this->cartService->getFromCookie();

        if ($cart) {
            $cart->products()->detach();
        }

        // Record the payment (assuming `payments` table exists)
        $order->payment()->create([
            'amount' => $order->total,
            'payed_at' => now(),
        ]);

        // Update order status to 'paid'
        $order->update(['status' => 'paid']);

        return redirect()
            ->route('main')
            ->with('success', "Thanks! We received your ₹{$order->total} payment.");
    }
}
