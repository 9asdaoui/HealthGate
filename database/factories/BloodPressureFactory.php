<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BloodPressure>
 */
class BloodPressureFactory extends Factory
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
            'systolic' => $this->faker->numberBetween(90, 180),
            'diastolic' => $this->faker->numberBetween(60, 120),
            'measured_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'unit' => 'mmHg',
        ];
    }
}
