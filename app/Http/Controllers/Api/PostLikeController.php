<?php

namespace App\Http\Controllers\Api;

use App\Actions\TogglePostLikeAction;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PostLikeController extends Controller
{
    public function __construct(
        private readonly TogglePostLikeAction $togglePostLikeAction,
    ) {}

    public function toggle(Request $request, string $slug): JsonResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'string', 'in:like,love,fire,celebrate,clap'],
        ]);

        try {
            $result = $this->togglePostLikeAction->execute(
                $slug,
                $request->ip(),
                $validated['type'],
            );

            return response()->json([
                'success' => true,
                'data' => $result,
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle reaction',
            ], 500);
        }
    }
}
