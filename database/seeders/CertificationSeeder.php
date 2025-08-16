<?php

namespace Database\Seeders;

use App\Models\Certification;
use Illuminate\Database\Seeder;

class CertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $certifications = [
            ['name' => 'Basic Certification', 'description' => 'Entry level certification', 'level' => 'basic', 'rate_multiplier' => 1.00],
            ['name' => 'Intermediate Certification', 'description' => 'Mid-level professional certification', 'level' => 'intermediate', 'rate_multiplier' => 1.25],
            ['name' => 'Advanced Certification', 'description' => 'Advanced professional certification', 'level' => 'advanced', 'rate_multiplier' => 1.50],
            ['name' => 'Expert Certification', 'description' => 'Master level certification', 'level' => 'expert', 'rate_multiplier' => 2.00],
        ];

        foreach ($certifications as $certification) {
            Certification::create($certification);
        }
    }
}