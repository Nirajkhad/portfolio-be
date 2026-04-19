<?php

namespace App\Http\Controllers\Api;

use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * ProjectController
 *
 * API endpoints for portfolio projects.
 */
class ProjectController extends Controller
{
    public function __construct(
        private readonly ProjectService $projectService,
    ) {}

    /**
     * Get all projects with technology stacks.
     */
    public function index(): JsonResponse
    {
        try {
            $projects = $this->projectService->getAll();

            return response()->json([
                'success' => true,
                'data' => $projects,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch projects',
            ], 500);
        }
    }

    /**
     * Get featured projects only.
     */
    public function featured(): JsonResponse
    {
        try {
            $projects = $this->projectService->getFeatured();

            return response()->json([
                'success' => true,
                'data' => $projects,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch featured projects',
            ], 500);
        }
    }
}
