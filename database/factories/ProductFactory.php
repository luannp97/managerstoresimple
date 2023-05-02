<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->jobTitle(),
            'description' => fake()->companySuffix(),
            'image' => fake()->text(),
            'status' => fake()->text(10),
            'store_id' => fake()->randomElement(Store::pluck('id')),
            'import_price' => fake()->randomNumber(9),
            'price' => fake()->randomNumber(9)+ 1000000,
            'product_code' => fake()->text(10),
            'product_type' => fake()->text(10),
            'total' => fake()->randomNumber(2)
        ];
    }
}
