<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DoctorSchedules>
 */
class DoctorSchedulesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'doctor_id' => \App\Models\Doctor::factory(),
            'time_slots' => json_encode($this->faker->randomElements([
                    '09:00 AM - 10:00 AM', 
                    '10:00 AM - 11:00 AM', 
                    '11:00 AM - 12:00 PM', 
                    '02:00 PM - 03:00 PM', 
                    '03:00 PM - 04:00 PM', 
                    '04:00 PM - 05:00 PM'], 
                rand(2, 6))),
        ];
    }
}
