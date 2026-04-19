<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Experience Model
 *
 * Represents a work experience/employment entry including:
 * - Company and position information
 * - Employment dates and type
 * - Current employment flag
 * - Associated achievement bullets
 *
 * @property string $id UUID primary key
 * @property string $company Company/organization name
 * @property string $role Job title/position
 * @property string|null $location Work location
 * @property string|null $employment_type Type: Full-time, Contract, Freelance, Part-time
 * @property Carbon $start_date Employment start date
 * @property Carbon|null $end_date Employment end date
 * @property bool $is_current Whether currently employed
 * @property int $sort_order Display order
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method HasMany bullets() Get associated experience bullets
 */
final class Experience extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'company',
        'role',
        'location',
        'employment_type',
        'start_date',
        'end_date',
        'is_current',
        'sort_order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the experience bullets (achievements) for this experience.
     */
    public function bullets(): HasMany
    {
        return $this->hasMany(ExperienceBullet::class);
    }
}
