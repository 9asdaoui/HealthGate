<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
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
            'appointment_date' => $this->faker->date(),
            'appointment_time' => function (array $attributes) {
                $timeSlots = [
                    '09:00 AM - 10:00 AM', 
                    '10:00 AM - 11:00 AM', 
                    '11:00 AM - 12:00 PM', 
                    '02:00 PM - 03:00 PM', 
                    '03:00 PM - 04:00 PM', 
                    '04:00 PM - 05:00 PM'
                ];
                return $this->faker->randomElement($timeSlots);
            },
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'reason' => $this->faker->sentence(),
        ];
    }
}
