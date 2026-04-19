<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * SocialLink Model
 *
 * Represents a social media profile or external link for the portfolio owner.
 * Allows dynamic management of social profiles without schema changes.
 *
 * @property string $id UUID primary key
 * @property string $general_info_id Foreign key to GeneralInfo
 * @property string $platform Platform name (GitHub, LinkedIn, LeetCode, Portfolio, Resume, etc.)
 * @property string $url URL to the social profile or external link
 * @property string|null $icon Icon identifier for UI rendering (e.g., 'fab fa-github')
 * @property int $sort_order Display order
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method BelongsTo generalInfo() Get the parent GeneralInfo
 */
final class SocialLink extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'general_info_id',
        'platform',
        'url',
        'icon',
        'sort_order',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the parent GeneralInfo for this social link.
     */
    public function generalInfo(): BelongsTo
    {
        return $this->belongsTo(GeneralInfo::class);
    }
}
