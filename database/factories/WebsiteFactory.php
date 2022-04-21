<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class WebsiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'url' => $this->faker->unique()->url,
            'description' => $this->faker->sentence(),
            'category' => $this->faker->word,
            'user_id' => User::all()->random()->id,
        ];
    }
}
