<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Post Model
 *
 * Represents a blog post with markdown content, metadata, and publication status.
 *
 * @property string $id UUID primary key
 * @property string $title Post title
 * @property string $slug URL-safe slug
 * @property string $excerpt Short summary for listing
 * @property string $body Full markdown content
 * @property string|null $cover_image Cover image URL
 * @property array|null $tags Array of tags
 * @property string $status Publication status: draft or published
 * @property Carbon|null $published_at Publication timestamp
 * @property int $read_time Estimated read time in minutes
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
final class Post extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'tags',
        'status',
        'published_at',
        'read_time',
    ];

    protected $casts = [
        'tags' => 'json',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
