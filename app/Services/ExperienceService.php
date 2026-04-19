<?php

namespace App\Services;

use App\Actions\GetAllExperiencesAction;
use App\Actions\GetExperienceAction;
use App\Models\Experience;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * ExperienceService
 *
 * Service layer for managing work experience business logic.
 * Coordinates actions for retrieving experience data.
 */
class ExperienceService
{
    /**
     * Create a new ExperienceService instance.
     */
    public function __construct(
        private readonly GetExperienceAction $getExperienceAction,
        private readonly GetAllExperiencesAction $getAllExperiencesAction,
    ) {}

    /**
     * Get a specific experience by ID with bullets.
     *
     * @param  string  $id  UUID of the experience
     * @return Experience
     *
     * @throws ModelNotFoundException
     */
    public function get(string $id): Model
    {
        return $this->getExperienceAction->execute($id);
    }

    /**
     * Get all experiences with bullets, ordered by sort_order.
     */
    public function getAll(): Collection
    {
        return $this->getAllExperiencesAction->execute();
    }
}
