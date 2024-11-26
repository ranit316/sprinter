<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //$userId = 1;
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'status' => fake()->randomElement(['Active', 'Inactive']),
            'photo' => 'image/category/4ef2f983834bdcf676c44dad74b16c0d7270c40f_1709752213.jpg',
            //'created_by' => $userId
        ];
    }
}
