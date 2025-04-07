<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medical>
 */
class MedicalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => \App\Models\Patient::factory(),
            'doctor_id' => \App\Models\Doctor::factory(),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'dosage' => $this->faker->numberBetween(1, 500) . 'mg',
            'frequency' => $this->faker->randomElement(['once daily', 'twice daily', 'three times daily', 'every 12 hours', 'every 8 hours', 'weekly']),
            'start_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+3 months'),
        ];
    }
}
