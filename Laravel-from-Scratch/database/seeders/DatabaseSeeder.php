<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Image;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 20 users and associate an image with each user
        $users = User::factory(20)
            ->create()
            ->each(function ($user) {
                $image = Image::factory()
                    ->user()
                    ->make();

                $user->image()->save($image);
            });

        // Create 10 orders and assign them to users
        $orders = Order::factory(10)
            ->make()
            ->each(function ($order) use ($users) {
                $order->customer_id = $users->random()->id;
                $order->save();

                // Create a payment and associate it with the order
                $payment = Payment::factory()->make();
                $order->payment()->save($payment);
            });

        // Create 20 carts
        $carts = Cart::factory(20)->create();

        // Create 50 products with INR prices and associate them with orders, carts, and images
        $products = Product::factory(50)
            ->create([
                'price' => fake()->randomFloat(2, 100, 500), // INR prices between ₹100 and ₹5000
            ])
            ->each(function ($product) use ($orders, $carts) {
                // Attach product to a random order with a random quantity
                $order = $orders->random();
                $order->products()->attach([
                    $product->id => ['quantity' => mt_rand(1, 3)]
                ]);

                // Attach product to a random cart with a random quantity
                $cart = $carts->random();
                $cart->products()->attach([
                    $product->id => ['quantity' => mt_rand(1, 3)]
                ]);

                // Assign 2-4 images to each product
                $images = Image::factory(mt_rand(2, 4))->make();
                $product->images()->saveMany($images);
            });
    }
}
