<?php

namespace App\Actions;

use App\Models\GeneralInfo;
use Illuminate\Database\Eloquent\Collection;

/**
 * GetAllGeneralInfoAction
 *
 * Action for retrieving all portfolio owner information records with social links.
 */
class GetAllGeneralInfoAction
{
    /**
     * Execute the action to get all general info records.
     */
    public function execute(): Collection
    {
        return GeneralInfo::with(['socialLinks' => fn ($query) => $query->orderBy('sort_order')])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
