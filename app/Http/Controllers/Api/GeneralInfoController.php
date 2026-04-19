<?php

namespace App\Http\Controllers\Api;

use App\Services\GeneralInfoService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * GeneralInfoController
 *
 * API endpoints for public portfolio information.
 * Uses service layer for business logic and actions for specific operations.
 */
class GeneralInfoController extends Controller
{
    /**
     * Create a new GeneralInfoController instance.
     */
    public function __construct(
        private readonly GeneralInfoService $generalInfoService,
    ) {}

    /**
     * Get the active portfolio owner information with social links.
     */
    public function show(): JsonResponse
    {
        try {
            $generalInfo = $this->generalInfoService->getActive();

            return response()->json([
                'success' => true,
                'data' => $generalInfo,
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => 'Portfolio information not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching portfolio information',
            ], 500);
        }
    }

    /**
     * Get all portfolio information records (admin only in production).
     */
    public function index(): JsonResponse
    {
        try {
            $generalInfos = $this->generalInfoService->getAll();

            return response()->json([
                'success' => true,
                'data' => $generalInfos,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch portfolio information',
            ], 500);
        }
    }
}
