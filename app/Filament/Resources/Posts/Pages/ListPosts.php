<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ListPosts extends ManageRecords
{
    protected static string $resource = PostResource::class;

    public function getTitle(): string
    {
        return 'Posts';
    }

    public function getHeading(): string
    {
        return 'Manage Blog Posts';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Write Post'),
        ];
    }
}
