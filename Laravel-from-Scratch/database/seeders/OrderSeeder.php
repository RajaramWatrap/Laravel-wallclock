<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        if (!$user) {
            $this->command->warn("No users found. Creating a default user.");
            $user = User::factory()->create();
        }

        $products = Product::all();
        if ($products->isEmpty()) {
            $this->command->warn("No products found. Please add products first.");
            return;
        }

        for ($i = 0; $i < 30; $i++) {
            $order = Order::create([
                'customer_id' => $user->id, // ✅ Fixed user_id issue
                'status' => 'completed',
                'address' => '123 Test Street, City ' . rand(1, 10), // ✅ Ensure address is set
                'created_at' => Carbon::now()->subDays(rand(0, 30)), 
                'updated_at' => Carbon::now(),
            ]);

            foreach ($products->random(rand(1, 3)) as $product) {
                DB::table('order_product')->insert([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 5),
                ]);
            }
        }
    }
}
