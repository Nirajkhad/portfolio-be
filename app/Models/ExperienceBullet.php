<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * ExperienceBullet Model
 *
 * Represents an individual achievement or responsibility bullet point for an experience.
 *
 * @property string $id UUID primary key
 * @property string $experience_id Foreign key to Experience
 * @property string $content Bullet point text content
 * @property int $sort_order Display order
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method BelongsTo experience() Get the parent Experience
 */
final class ExperienceBullet extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'experience_id',
        'content',
        'sort_order',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the parent Experience for this bullet.
     */
    public function experience(): BelongsTo
    {
        return $this->belongsTo(Experience::class);
    }
}
