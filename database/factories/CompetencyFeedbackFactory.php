<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompetencyFeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'competency_name' => $this->faker->randomElement([
                'Domínio da Forma Escrita Padrão do Português',
                'Compreensão do tema',
                'Argumentação e Persuasão',
                'Coesão e Coerência Textual',
                'Proposta de Intervenção',
            ]),
            'score' => $this->faker->numberBetween(0, 200),
            'feedback_text' => $this->faker->sentence(10),
        ];
    }
}
