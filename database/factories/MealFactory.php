<?php

namespace Database\Factories;

use FakerRestaurant\Provider\pt_BR\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meal>
 */
class MealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        fake()->addProvider(new Restaurant(fake()));
        return [
            'name' => fake()->meatName()
        ];
    }
}
