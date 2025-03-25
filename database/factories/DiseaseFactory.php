<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Disease>
 */
class DiseaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word . ' Disease',
            'category' => $this->faker->randomElement(['viral', 'bacterial', 'fungal', 'parasitic']),
            'description' => $this->faker->paragraph(3),
            'symptoms' => $this->faker->sentence(5),
            'prevention' => $this->faker->sentence(4),
            'treatment' => $this->faker->sentence(4),
            'image' => $this->faker->imageUrl(640, 480, 'health', true),
        ];
    }
}
