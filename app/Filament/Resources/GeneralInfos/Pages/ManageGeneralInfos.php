<?php

namespace App\Filament\Resources\GeneralInfos\Pages;

use App\Filament\Resources\GeneralInfos\GeneralInfoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageGeneralInfos extends ManageRecords
{
    protected static string $resource = GeneralInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add General Info'),
        ];
    }

    public function getTitle(): string
    {
        return 'Portfolio Information';
    }

    public function getHeading(): string
    {
        return 'Manage Your Portfolio Information';
    }
}
