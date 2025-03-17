<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Image;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fileName = $this->faker->numberBetween(1, 10) . '.jpg';

        return [
            'path' => "img/products/{$fileName}",
        ];
    }

    /**
     * Define a user image state.
     */
    public function user(): static
    {
        $fileName = $this->faker->numberBetween(1, 6) . '.jpg';

        return $this->state(fn (array $attributes) => [
            'path' => "img/users/{$fileName}",
        ]);
    }
}
