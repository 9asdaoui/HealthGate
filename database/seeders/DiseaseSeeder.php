<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diseases = [
            [
            'name' => 'Hypertension',
            'description' => 'High blood pressure that can lead to serious health problems if untreated.',
            'category' => 'bacterial',
            'symptoms' => 'Headaches, shortness of breath, nosebleeds',
            'prevention' => 'Regular exercise, healthy diet, limiting salt intake',
            'treatment' => 'ACE inhibitors, diuretics, lifestyle changes',
            'image' => 'https://omronhealthcare-ap.com/healthblog/Content/uploads/400a9695b9c340feaf8b9f3357043214.jpg',
            ],
            [
            'name' => 'Type 2 Diabetes',
            'description' => 'A chronic condition affecting how the body processes blood sugar.',
            'category' => 'viral',
            'symptoms' => 'Increased thirst, frequent urination, hunger, fatigue',
            'prevention' => 'Healthy diet, regular exercise, weight management',
            'treatment' => 'Insulin therapy, oral medications, lifestyle changes',
            'image' => 'https://www.wshc.org/assets/Type-2-Diabetes-Nov-2022.jpg',
            ],
            [
            'name' => 'Asthma',
            'description' => 'A condition where airways narrow and swell, producing extra mucus.',
            'category' => 'parasitic',
            'symptoms' => 'Wheezing, shortness of breath, chest tightness, coughing',
            'prevention' => 'Avoid triggers, maintain clean environment',
            'treatment' => 'Inhalers, bronchodilators, steroids',
            'image' => 'https://www.metropolisindia.com/upgrade/blog/upload/2022/11/Asthma-Symptoms-Causes-Types-Diagnosis-_-Treatment-1.jpg',
            ],
            [
            'name' => 'Influenza',
            'description' => 'Contagious respiratory illness caused by influenza viruses.',
            'category' => 'viral',
            'symptoms' => 'Fever, cough, sore throat, body aches, fatigue',
            'prevention' => 'Annual vaccination, hand washing, avoiding sick people',
            'treatment' => 'Antiviral medications, rest, fluids',
            'image' => 'https://hospitalcmq.com/wp-content/uploads/2019/02/H1N1.jpg.webp',
            ],
            [
            'name' => 'Rheumatoid Arthritis',
            'description' => 'Autoimmune disease causing inflammation of the joints.',
            'category' => 'genetic',
            'symptoms' => 'Joint pain, swelling, stiffness, fatigue',
            'prevention' => 'Regular exercise, maintaining healthy weight',
            'treatment' => 'DMARDs, NSAIDs, physical therapy',
            'image' => 'https://sa1s3optim.patientpop.com/assets/images/provider/photos/1699525.jpg',
            ],
        ];

        foreach ($diseases as $disease) {
            \App\Models\Disease::create($disease);
        }
    }
}
