<?php

namespace App\Filament\Resources\Experiences\Pages;

use App\Filament\Resources\Experiences\ExperienceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExperiences extends ListRecords
{
    protected static string $resource = ExperienceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add Experience'),
        ];
    }

    public function getTitle(): string
    {
        return 'Work Experience';
    }

    public function getHeading(): string
    {
        return 'Manage Your Work Experience';
    }
}
