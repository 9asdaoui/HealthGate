<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory()->create([
                'role_id' => 2, // Doctor role
            ])->id,
            'speciality' => $this->faker->randomElement(['Cardiology', 'Neurology', 'Pediatrics', 'Orthopedics', 'Dermatology']),
            'experience' => $this->faker->numberBetween(1, 20),
            'department_id' => \App\Models\Department::factory(),
        ];
    }
}
