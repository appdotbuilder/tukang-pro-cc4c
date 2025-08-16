<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CraftsmanSkill
 *
 * @property int $id
 * @property int $craftsman_profile_id
 * @property int $skill_id
 * @property int|null $certification_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CraftsmanProfile $craftsmanProfile
 * @property-read \App\Models\Skill $skill
 * @property-read \App\Models\Certification|null $certification
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanSkill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanSkill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanSkill query()
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanSkill whereCertificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanSkill whereCraftsmanProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanSkill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanSkill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanSkill whereSkillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanSkill whereUpdatedAt($value)
 * @method static \Database\Factories\CraftsmanSkillFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class CraftsmanSkill extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'craftsman_profile_id',
        'skill_id',
        'certification_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the craftsman profile that owns this skill.
     */
    public function craftsmanProfile(): BelongsTo
    {
        return $this->belongsTo(CraftsmanProfile::class);
    }

    /**
     * Get the skill for this craftsman skill.
     */
    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    /**
     * Get the certification for this craftsman skill.
     */
    public function certification(): BelongsTo
    {
        return $this->belongsTo(Certification::class);
    }
}