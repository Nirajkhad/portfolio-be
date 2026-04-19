<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Project Model
 *
 * Represents a completed portfolio project including:
 * - Project title, description, and links
 * - Featured and sorting status
 * - Associated technology stack
 *
 * @property string $id UUID primary key
 * @property string $title Project title
 * @property string $description Project description
 * @property string|null $github_url Link to GitHub repository
 * @property string|null $live_url Link to live project
 * @property string|null $thumbnail_url Project thumbnail image URL
 * @property bool $is_featured Whether project is featured
 * @property int $sort_order Display order
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method HasMany techStacks() Get associated technology stack
 */
final class Project extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'description',
        'github_url',
        'live_url',
        'thumbnail_url',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the technology stack for this project.
     */
    public function techStacks(): HasMany
    {
        return $this->hasMany(ProjectTechStack::class);
    }
}
