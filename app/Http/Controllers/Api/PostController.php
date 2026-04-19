<?php

namespace App\Http\Controllers\Api;

use App\Services\PostService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * PostController
 *
 * API endpoints for blog posts.
 */
class PostController extends Controller
{
    public function __construct(
        private readonly PostService $postService,
    ) {}

    /**
     * Get all posts.
     */
    public function index(): JsonResponse
    {
        try {
            $posts = $this->postService->getAll();

            return response()->json([
                'success' => true,
                'data' => $posts,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch posts',
            ], 500);
        }
    }

    /**
     * Get published posts only.
     */
    public function published(): JsonResponse
    {
        try {
            $posts = $this->postService->getPublished();

            return response()->json([
                'success' => true,
                'data' => $posts,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch published posts',
            ], 500);
        }
    }

    /**
     * Get a specific post by slug.
     *
     * @param  string  $slug  URL slug of the post
     */
    public function show(string $slug): JsonResponse
    {
        try {
            $post = $this->postService->get($slug);

            return response()->json([
                'success' => true,
                'data' => $post,
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch post',
            ], 500);
        }
    }
}
