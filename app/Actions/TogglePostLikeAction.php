<?php

namespace App\Actions;

use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TogglePostLikeAction
{
    private const REACTION_TYPES = ['like', 'love', 'fire', 'celebrate', 'clap'];

    public function execute(string $slug, string $ipAddress, string $type): array
    {
        if (!in_array($type, self::REACTION_TYPES, true)) {
            throw new \InvalidArgumentException("Invalid reaction type: $type");
        }

        $post = Post::where('slug', $slug)->firstOrFail();

        $existingLike = PostLike::where('post_id', $post->id)
            ->where('ip_address', $ipAddress)
            ->where('type', $type)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            PostLike::create([
                'post_id' => $post->id,
                'ip_address' => $ipAddress,
                'type' => $type,
            ]);
        }

        $userReactions = PostLike::where('post_id', $post->id)
            ->where('ip_address', $ipAddress)
            ->pluck('type')
            ->toArray();

        return [
            'user_reactions' => $userReactions,
            'reactions' => $post->reactions,
        ];
    }
}
