<?php

namespace App\Actions;

use App\Models\GeneralInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * GetGeneralInfoAction
 *
 * Action for retrieving the active portfolio owner information with social links.
 */
class GetGeneralInfoAction
{
    /**
     * Execute the action to get active general info.
     *
     * @return GeneralInfo
     *
     * @throws ModelNotFoundException
     */
    public function execute(): Model
    {
        return GeneralInfo::where('is_active', true)
            ->with(['socialLinks' => fn ($query) => $query->orderBy('sort_order')])
            ->firstOrFail();
    }
}
