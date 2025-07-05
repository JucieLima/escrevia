<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EssayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'title' => $this->faker->sentence(4),
            'content' => $this->faker->paragraphs(5, true),
            'overall_score' => $this->faker->numberBetween(400, 1000),
        ];
    }
}
