<?php

namespace App\Http\Controllers\Api;

use App\Services\SkillService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * SkillController
 *
 * API endpoints for professional skills.
 */
class SkillController extends Controller
{
    public function __construct(
        private readonly SkillService $skillService,
    ) {}

    /**
     * Get all skills.
     */
    public function index(): JsonResponse
    {
        try {
            $skills = $this->skillService->getAll();

            return response()->json([
                'success' => true,
                'data' => $skills,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch skills',
            ], 500);
        }
    }

    /**
     * Get skills grouped by category.
     */
    public function grouped(): JsonResponse
    {
        try {
            $skills = $this->skillService->getAllGroupedByCategory();

            return response()->json([
                'success' => true,
                'data' => $skills,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch skills',
            ], 500);
        }
    }
}
