<?php

namespace Database\Factories;

use App\Models\CraftsmanProfile;
use App\Models\Skill;
use App\Models\Certification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CraftsmanSkill>
 */
class CraftsmanSkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'craftsman_profile_id' => CraftsmanProfile::factory(),
            'skill_id' => Skill::factory(),
            'certification_id' => Certification::factory(),
        ];
    }
}