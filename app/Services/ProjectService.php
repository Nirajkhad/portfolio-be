<?php

namespace App\Services;

use App\Actions\GetAllProjectsAction;
use Illuminate\Database\Eloquent\Collection;

/**
 * ProjectService
 *
 * Service layer for managing portfolio projects business logic.
 */
class ProjectService
{
    public function __construct(
        private readonly GetAllProjectsAction $getAllProjectsAction,
    ) {}

    /**
     * Get all projects.
     */
    public function getAll(): Collection
    {
        return $this->getAllProjectsAction->execute();
    }

    /**
     * Get featured projects.
     */
    public function getFeatured(): Collection
    {
        return $this->getAllProjectsAction->execute(featured: true);
    }
}
