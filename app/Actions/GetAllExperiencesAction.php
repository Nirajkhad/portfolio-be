<?php

namespace App\Actions;

use App\Models\Experience;
use Illuminate\Database\Eloquent\Collection;

/**
 * GetAllExperiencesAction
 *
 * Action for retrieving all work experiences with associated bullets, ordered by sort_order.
 */
class GetAllExperiencesAction
{
    /**
     * Execute the action to get all experiences.
     */
    public function execute(): Collection
    {
        return Experience::with(['bullets' => fn ($query) => $query->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->orderBy('start_date', 'desc')
            ->get();
    }
}
