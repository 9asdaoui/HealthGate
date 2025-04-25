<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => 1,
        ]);

        $doc = \App\Models\User::factory()->create([
            'email' => 'doctor@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => 2,
        ]);

        \App\Models\Doctor::factory()->create([
            'user_id' => $doc->id,
            'speciality' => 'Cardiology',
            'experience' => 5,
            'department_id' => 1,
        ]);

        $patient = \App\Models\User::factory()->create([
            'email' => 'patient@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => 3,
        ]);

        \App\Models\Patient::factory()->create([
            'user_id' => $patient->id,
            'height' => 175.5,
            'weight' => 70.2,
            'date_of_birth' => now()->subYears(30),
        ]);
    }
}
