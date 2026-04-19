<?php

namespace App\Services;

use App\Actions\GetAllGeneralInfoAction;
use App\Actions\GetGeneralInfoAction;
use App\Models\GeneralInfo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * GeneralInfoService
 *
 * Service layer for managing general information business logic.
 * Coordinates actions for retrieving portfolio data.
 */
class GeneralInfoService
{
    /**
     * Create a new GeneralInfoService instance.
     */
    public function __construct(
        private readonly GetGeneralInfoAction $getGeneralInfoAction,
        private readonly GetAllGeneralInfoAction $getAllGeneralInfoAction,
    ) {}

    /**
     * Get the active portfolio information.
     *
     * @return GeneralInfo
     *
     * @throws ModelNotFoundException
     */
    public function getActive(): Model
    {
        return $this->getGeneralInfoAction->execute();
    }

    /**
     * Get all portfolio information records.
     */
    public function getAll(): Collection
    {
        return $this->getAllGeneralInfoAction->execute();
    }
}
