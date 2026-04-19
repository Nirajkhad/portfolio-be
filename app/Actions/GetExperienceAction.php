<?php

namespace App\Actions;

use App\Models\Experience;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * GetExperienceAction
 *
 * Action for retrieving a single work experience with associated bullets.
 */
class GetExperienceAction
{
    /**
     * Execute the action to get a specific experience.
     *
     * @param  string  $id  UUID of the experience
     * @return Experience
     *
     * @throws ModelNotFoundException
     */
    public function execute(string $id): Model
    {
        return Experience::with(['bullets' => fn ($query) => $query->orderBy('sort_order')])
            ->findOrFail($id);
    }
}
