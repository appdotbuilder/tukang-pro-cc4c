<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            ['name' => 'Plumbing', 'description' => 'Water systems installation and repair', 'base_rate' => 80.00],
            ['name' => 'Electrical', 'description' => 'Electrical systems and wiring', 'base_rate' => 90.00],
            ['name' => 'Carpentry', 'description' => 'Woodwork and furniture making', 'base_rate' => 75.00],
            ['name' => 'Painting', 'description' => 'Interior and exterior painting', 'base_rate' => 60.00],
            ['name' => 'Masonry', 'description' => 'Stone and brick work', 'base_rate' => 85.00],
            ['name' => 'Roofing', 'description' => 'Roof installation and repair', 'base_rate' => 95.00],
            ['name' => 'Welding', 'description' => 'Metal fabrication and welding', 'base_rate' => 100.00],
            ['name' => 'HVAC', 'description' => 'Heating, ventilation, and air conditioning', 'base_rate' => 110.00],
            ['name' => 'Flooring', 'description' => 'Floor installation and refinishing', 'base_rate' => 70.00],
            ['name' => 'Tiling', 'description' => 'Ceramic and stone tile installation', 'base_rate' => 65.00],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}