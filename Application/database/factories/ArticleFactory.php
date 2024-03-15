<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'title' => fake()->sentence,
            'content' => fake()->text,
            'publish_status' => fake()->boolean,
            'publish_date' => fake()->dateTimeBetween('-1 year', '+1 year'),
            'approve_status' => fake()->boolean,
            'approve_date' => fake()->boolean ? fake()->dateTimeBetween('-1 year', '+1 year') : null,
        ];
    }
}
