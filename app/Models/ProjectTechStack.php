<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * ProjectTechStack Model
 *
 * Represents a technology or tool used in a project.
 *
 * @property string $id UUID primary key
 * @property string $project_id Foreign key to Project
 * @property string $name Technology/tool name
 * @property int $sort_order Display order
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method BelongsTo project() Get the parent Project
 */
final class ProjectTechStack extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'project_id',
        'name',
        'sort_order',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the parent Project for this technology.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
