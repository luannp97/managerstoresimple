<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company(),
            'address' => fake()->address(),
            'is_active' => true,
            'author_id' => fake()->randomElement(User::pluck('id')),
            'image' => fake()->text(),
            'store_code' => fake()->text(10),
            'type_of'=> fake()->text(10)
        ];
    }
}
