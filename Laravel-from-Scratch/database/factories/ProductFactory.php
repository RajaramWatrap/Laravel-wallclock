<?php

namespace Database\Factories;

use App\Models\Product; // ✅ Import Product model
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class; // ✅ Bind factory to Product model

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(1),
            'price' => $this->faker->randomFloat(2, 3, 50),
            'stock' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->randomElement(['available', 'unavailable']),
        ];
    }
}
