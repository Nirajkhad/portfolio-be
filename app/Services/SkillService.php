<?php

namespace App\Services;

use App\Actions\GetAllSkillsAction;
use Illuminate\Database\Eloquent\Collection;

/**
 * SkillService
 *
 * Service layer for managing professional skills business logic.
 */
class SkillService
{
    public function __construct(
        private readonly GetAllSkillsAction $getAllSkillsAction,
    ) {}

    /**
     * Get all skills.
     */
    public function getAll(): Collection
    {
        return $this->getAllSkillsAction->execute();
    }

    /**
     * Get skills grouped by category.
     */
    public function getAllGroupedByCategory(): array
    {
        return $this->getAll()->groupBy('category')->toArray();
    }
}
