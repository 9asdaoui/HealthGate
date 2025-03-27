<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'doctor']);
        Role::create(['name' => 'patient']);
        
        \App\Models\Doctor::factory(10)->create();
        \App\Models\Patient::factory(10)->create();
        \App\Models\Medical::factory(10)->create();
        \App\Models\HearthRate::factory(10)->create();
        \App\Models\Appointment::factory(10)->create();
        \App\Models\BloodPressure::factory(10)->create();
        \App\Models\BloodSugar::factory(10)->create();
        \App\Models\Disease::factory(10)->create();




        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
