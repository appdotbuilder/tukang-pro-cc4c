<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CraftsmanProfile;
use App\Models\ServiceRequest;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SkillSeeder::class,
            CertificationSeeder::class,
        ]);

        // Create admin user
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@craftsmanapp.com',
            'role' => 'admin',
            'phone' => '+1234567890',
            'address' => '123 Admin Street, City',
        ]);

        // Create sample customers
        User::factory(5)->create(['role' => 'customer']);

        // Create sample craftsmen with profiles
        $craftsmen = User::factory(10)->create(['role' => 'craftsman']);
        
        foreach ($craftsmen as $craftsman) {
            $profile = CraftsmanProfile::factory()->create([
                'user_id' => $craftsman->id,
            ]);
            
            // Assign random skills to craftsmen
            $skills = \App\Models\Skill::inRandomOrder()->limit(random_int(2, 4))->get();
            foreach ($skills as $skill) {
                \App\Models\CraftsmanSkill::create([
                    'craftsman_profile_id' => $profile->id,
                    'skill_id' => $skill->id,
                    'certification_id' => \App\Models\Certification::inRandomOrder()->first()->id,
                ]);
            }
        }

        // Create sample service requests
        ServiceRequest::factory(20)->create();
    }
}
