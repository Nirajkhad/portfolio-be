<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * GeneralInfo Model
 *
 * Represents the portfolio owner's general information including:
 * - Personal details (name, title, bio, contact)
 * - Dynamic social links managed separately
 * - Active status flag
 *
 * @property string $id UUID primary key
 * @property string $full_name The owner's full name
 * @property string $title Professional title/role
 * @property string $bio Professional bio/summary
 * @property string $email Email address
 * @property string|null $phone Phone number
 * @property string|null $location Geographic location
 * @property bool $is_active Whether profile is active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method HasMany socialLinks() Get associated social links
 */
final class GeneralInfo extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'full_name',
        'title',
        'bio',
        'email',
        'phone',
        'location',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all social links for this portfolio owner.
     */
    public function socialLinks(): HasMany
    {
        return $this->hasMany(SocialLink::class)->orderBy('sort_order');
    }
}
