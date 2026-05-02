<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_text' => rtrim(fake()->sentence(), '.').'?',
            'placeholder' => fake()->sentence(4),
            'sort_order' => fake()->numberBetween(1, 20),
            'is_active' => true,
        ];
    }
}
