<?php

namespace App\Actions;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Collection;

/**
 * GetAllSkillsAction
 *
 * Action for retrieving professional skills organized by category.
 */
class GetAllSkillsAction
{
    /**
     * Execute the action to get all skills.
     */
    public function execute(): Collection
    {
        return Skill::orderBy('category')
            ->orderBy('sort_order')
            ->get();
    }
}
