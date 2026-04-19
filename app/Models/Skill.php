<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Skill Model
 *
 * Represents a professional skill organized by category.
 *
 * @property string $id UUID primary key
 * @property string $category Skill category (Languages, Frameworks, Databases, Tools, Cloud)
 * @property string $name Skill name
 * @property int $sort_order Display order
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
final class Skill extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'category',
        'name',
        'sort_order',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
