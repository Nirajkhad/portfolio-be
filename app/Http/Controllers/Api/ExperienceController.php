<?php

namespace App\Http\Controllers\Api;

use App\Services\ExperienceService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * ExperienceController
 *
 * API endpoints for portfolio work experiences.
 * Uses service layer for business logic and actions for specific operations.
 */
class ExperienceController extends Controller
{
    /**
     * Create a new ExperienceController instance.
     */
    public function __construct(
        private readonly ExperienceService $experienceService,
    ) {}

    /**
     * Get all work experiences with achievements.
     */
    public function index(): JsonResponse
    {
        try {
            $experiences = $this->experienceService->getAll();

            return response()->json([
                'success' => true,
                'data' => $experiences,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch experiences',
            ], 500);
        }
    }

    /**
     * Get a specific work experience by ID.
     *
     * @param  string  $id  UUID of the experience
     */
    public function show(string $id): JsonResponse
    {
        try {
            $experience = $this->experienceService->get($id);

            return response()->json([
                'success' => true,
                'data' => $experience,
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => 'Experience not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch experience',
            ], 500);
        }
    }
}
