<?php

namespace App\Actions;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * GetPostAction
 *
 * Action for retrieving a single blog post by slug.
 */
class GetPostAction
{
    /**
     * Execute the action to get a specific post by slug.
     *
     * @param  string  $slug  URL slug of the post
     * @return Post
     *
     * @throws ModelNotFoundException
     */
    public function execute(string $slug): Model
    {
        return Post::where('slug', $slug)->firstOrFail();
    }
}
