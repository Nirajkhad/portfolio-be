<?php

namespace App\Services;

use App\Actions\GetAllPostsAction;
use App\Actions\GetPostAction;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * PostService
 *
 * Service layer for managing blog posts business logic.
 */
class PostService
{
    public function __construct(
        private readonly GetAllPostsAction $getAllPostsAction,
        private readonly GetPostAction $getPostAction,
    ) {}

    /**
     * Get all posts.
     */
    public function getAll(): Collection
    {
        return $this->getAllPostsAction->execute();
    }

    /**
     * Get published posts only.
     */
    public function getPublished(): Collection
    {
        return $this->getAllPostsAction->execute(published: true);
    }

    /**
     * Get a specific post by slug.
     */
    public function get(string $slug): Model
    {
        return $this->getPostAction->execute($slug);
    }
}
