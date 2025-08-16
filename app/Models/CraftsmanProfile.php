<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\CraftsmanProfile
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $bio
 * @property int $years_experience
 * @property float|null $hourly_rate
 * @property string|null $location
 * @property float $rating
 * @property int $total_reviews
 * @property array|null $work_areas
 * @property string|null $profile_photo
 * @property bool $is_available
 * @property bool $is_verified
 * @property float $insurance_rate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CraftsmanSkill> $skills
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanProfile whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanProfile whereHourlyRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanProfile whereInsuranceRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanProfile whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanProfile whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanProfile whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanProfile whereProfilePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanProfile whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanProfile whereTotalReviews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanProfile whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanProfile whereWorkAreas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanProfile whereYearsExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanProfile available()
 * @method static \Illuminate\Database\Eloquent\Builder|CraftsmanProfile verified()
 * @method static \Database\Factories\CraftsmanProfileFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class CraftsmanProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'bio',
        'years_experience',
        'hourly_rate',
        'location',
        'rating',
        'total_reviews',
        'work_areas',
        'profile_photo',
        'is_available',
        'is_verified',
        'insurance_rate',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'years_experience' => 'integer',
        'hourly_rate' => 'decimal:2',
        'rating' => 'decimal:2',
        'total_reviews' => 'integer',
        'work_areas' => 'array',
        'is_available' => 'boolean',
        'is_verified' => 'boolean',
        'insurance_rate' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include available craftsmen.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope a query to only include verified craftsmen.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Get the user that owns this craftsman profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the skills for this craftsman.
     */
    public function skills(): HasMany
    {
        return $this->hasMany(CraftsmanSkill::class);
    }
}