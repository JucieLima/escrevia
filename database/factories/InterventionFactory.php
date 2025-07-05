<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InterventionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $types = ['meta', 'reflexão', 'dica', 'motivacional'];

        return [
            'essay_id' => \App\Models\Essay::factory(),
            'user_id' => \App\Models\User::factory(),
            'type' => $this->faker->randomElement($types),
            'message' => $this->faker->sentence(12),
            'suggested_action' => $this->faker->optional()->sentence(),
        ];
    }
}
