<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * ProjectForm
 *
 * Form schema configuration for creating and editing portfolio projects.
 */
class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Project Details')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->label('Project Title')
                            ->maxLength(255),
                        Textarea::make('description')
                            ->required()
                            ->label('Description')
                            ->rows(5)
                            ->columnSpanFull(),
                    ])->columns(1),

                Section::make('Links')
                    ->schema([
                        TextInput::make('github_url')
                            ->label('GitHub Repository')
                            ->url()
                            ->placeholder('https://github.com/user/project')
                            ->columnSpanFull(),
                        TextInput::make('live_url')
                            ->label('Live Demo')
                            ->url()
                            ->placeholder('https://project-demo.com')
                            ->columnSpanFull(),
                        TextInput::make('thumbnail_url')
                            ->label('Thumbnail Image')
                            ->url()
                            ->placeholder('https://example.com/image.jpg')
                            ->helperText('Project screenshot or thumbnail image URL')
                            ->columnSpanFull(),
                    ]),

                Section::make('Technology Stack')
                    ->description('Add technologies and tools used in this project')
                    ->schema([
                        Repeater::make('techStacks')
                            ->relationship()
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->label('Technology/Tool')
                                    ->placeholder('e.g., Laravel, React, Docker')
                                    ->columnSpanFull(),
                                TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Display order')
                                    ->columnSpan(1),
                            ])
                            ->columns(1)
                            ->orderColumn('sort_order')
                            ->addActionLabel('+ Add technology')
                            ->defaultItems(0)
                            ->collapsed()
                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                            ->columnSpanFull(),
                    ]),

                Section::make('Settings')
                    ->schema([
                        Toggle::make('is_featured')
                            ->label('Featured Project')
                            ->helperText('Featured projects appear prominently on the portfolio')
                            ->columnSpanFull(),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->label('Display Order')
                            ->helperText('Lower numbers appear first')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
