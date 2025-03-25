<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HearthRate>
 */
class HearthRateFactory extends Factory
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
            'value' => $this->faker->numberBetween(60, 100),
            'measured_at' => $this->faker->dateTimeThisMonth(),
            'unit' => 'bpm',
        ];
    }
}
