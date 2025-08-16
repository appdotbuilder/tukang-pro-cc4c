<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Certification
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $level
 * @property float $rate_multiplier
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CraftsmanSkill> $craftsmanSkills
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Certification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Certification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Certification query()
 * @method static \Illuminate\Database\Eloquent\Builder|Certification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certification whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certification whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certification whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certification whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certification whereRateMultiplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certification active()
 * @method static \Database\Factories\CertificationFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Certification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'level',
        'rate_multiplier',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rate_multiplier' => 'decimal:2',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include active certifications.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get craftsman skills with this certification.
     */
    public function craftsmanSkills(): HasMany
    {
        return $this->hasMany(CraftsmanSkill::class);
    }
}