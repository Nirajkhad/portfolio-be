<?php

namespace App\Filament\Resources\Skills\Pages;

use App\Filament\Resources\Skills\SkillResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ListSkills extends ManageRecords
{
    protected static string $resource = SkillResource::class;

    public function getTitle(): string
    {
        return 'Skills';
    }

    public function getHeading(): string
    {
        return 'Manage Professional Skills';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add Skill'),
        ];
    }
}
