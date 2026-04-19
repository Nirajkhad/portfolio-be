<?php

namespace App\Filament\Resources\Experiences\Pages;

use App\Filament\Resources\Experiences\ExperienceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExperience extends CreateRecord
{
    protected static string $resource = ExperienceResource::class;

    public function getTitle(): string
    {
        return 'Create Experience';
    }

    public function getHeading(): string
    {
        return 'Add New Work Experience';
    }
}
