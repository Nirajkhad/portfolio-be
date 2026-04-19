<?php

namespace App\Actions;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

/**
 * GetAllPostsAction
 *
 * Action for retrieving published or all blog posts.
 */
class GetAllPostsAction
{
    /**
     * Execute the action to get all posts.
     *
     * @param  bool  $published  Only get published posts
     */
    public function execute(bool $published = false): Collection
    {
        $query = Post::query();

        if ($published) {
            $query->where('status', 'published')
                ->whereNotNull('published_at');
        }

        return $query->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
