<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ListProjects extends ManageRecords
{
    protected static string $resource = ProjectResource::class;

    public function getTitle(): string
    {
        return 'Projects';
    }

    public function getHeading(): string
    {
        return 'Manage Portfolio Projects';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add Project'),
        ];
    }
}
