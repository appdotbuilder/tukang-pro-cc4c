<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\ServiceRequest
 *
 * @property int $id
 * @property int $customer_id
 * @property int|null $craftsman_id
 * @property int $skill_id
 * @property string $title
 * @property string $description
 * @property string $location
 * @property float|null $estimated_budget
 * @property \Illuminate\Support\Carbon|null $preferred_date
 * @property string $status
 * @property float|null $final_amount
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property array|null $photos
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $customer
 * @property-read \App\Models\User|null $craftsman
 * @property-read \App\Models\Skill $skill
 * @property-read \App\Models\Review|null $review
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest whereCraftsmanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest whereEstimatedBudget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest whereFinalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest wherePhotos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest wherePreferredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest whereSkillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest pending()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceRequest completed()
 * @method static \Database\Factories\ServiceRequestFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class ServiceRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'customer_id',
        'craftsman_id',
        'skill_id',
        'title',
        'description',
        'location',
        'estimated_budget',
        'preferred_date',
        'status',
        'final_amount',
        'started_at',
        'completed_at',
        'photos',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'estimated_budget' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'preferred_date' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'photos' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include pending requests.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include completed requests.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Get the customer that made this request.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the craftsman assigned to this request.
     */
    public function craftsman(): BelongsTo
    {
        return $this->belongsTo(User::class, 'craftsman_id');
    }

    /**
     * Get the skill for this request.
     */
    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    /**
     * Get the review for this service request.
     */
    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }
}