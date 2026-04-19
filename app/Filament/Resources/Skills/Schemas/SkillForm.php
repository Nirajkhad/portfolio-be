<?php

namespace App\Filament\Resources\Skills\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * SkillForm
 *
 * Form schema configuration for creating and editing professional skills.
 */
class SkillForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Skill Information')
                    ->schema([
                        Select::make('category')
                            ->required()
                            ->label('Category')
                            ->options([
                                'Languages' => 'Languages',
                                'Frameworks' => 'Frameworks',
                                'Databases' => 'Databases',
                                'Tools' => 'Tools',
                                'Cloud' => 'Cloud',
                                'Other' => 'Other',
                            ])
                            ->placeholder('Select a category')
                            ->columnSpanFull(),
                        TextInput::make('name')
                            ->required()
                            ->label('Skill Name')
                            ->placeholder('e.g., Laravel, React, PostgreSQL')
                            ->maxLength(255)
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
