<?php

namespace App\Actions;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

/**
 * GetAllProjectsAction
 *
 * Action for retrieving featured or all portfolio projects with technology stacks.
 */
class GetAllProjectsAction
{
    /**
     * Execute the action to get all projects.
     *
     * @param  bool  $featured  Only get featured projects
     */
    public function execute(bool $featured = false): Collection
    {
        $query = Project::with(['techStacks' => fn ($q) => $q->orderBy('sort_order')]);

        if ($featured) {
            $query->where('is_featured', true);
        }

        return $query->orderBy('sort_order')
            ->get();
    }
}
