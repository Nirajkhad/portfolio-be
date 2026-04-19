<?php

namespace App\Filament\Resources\Experiences\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

/**
 * ExperienceForm
 *
 * Form schema configuration for creating and editing work experiences.
 */
class ExperienceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Employment Details')
                    ->schema([
                        TextInput::make('company')
                            ->required()
                            ->label('Company/Organization')
                            ->maxLength(255),
                        TextInput::make('role')
                            ->required()
                            ->label('Job Title')
                            ->placeholder('Backend Engineer')
                            ->maxLength(255),
                        TextInput::make('location')
                            ->label('Location')
                            ->placeholder('Remote or City Name')
                            ->maxLength(255),
                        Select::make('employment_type')
                            ->label('Employment Type')
                            ->options([
                                'Full-time' => 'Full-time',
                                'Part-time' => 'Part-time',
                                'Contract' => 'Contract',
                                'Freelance' => 'Freelance',
                                'Internship' => 'Internship',
                            ])
                            ->placeholder('Select employment type'),
                    ])->columns(2),

                Section::make('Duration')
                    ->schema([
                        DatePicker::make('start_date')
                            ->required()
                            ->label('Start Date'),
                        DatePicker::make('end_date')
                            ->label('End Date')
                            ->disabled(static fn (Get $get) => $get('is_current')),
                        Toggle::make('is_current')
                            ->label('Currently Working Here')
                            ->default(false),
                    ])->columns(3),

                Section::make('Responsibilities')
                    ->schema([
                        Repeater::make('bullets')
                            ->relationship('bullets')
                            ->schema([
                                Textarea::make('content')
                                    ->required()
                                    ->rows(2)
                                    ->columnSpanFull(),
                                TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Display order')
                                    ->columnSpan(1),
                            ])
                            ->columns(2)
                            ->orderColumn('sort_order')
                            ->addActionLabel('Add bullet point')
                            ->defaultItems(0)
                            ->collapsed()
                            ->itemLabel(fn (array $state): ?string => substr($state['content'] ?? '', 0, 40) . (strlen($state['content'] ?? '') > 40 ? '...' : ''))
                            ->columnSpanFull(),
                    ]),

                Section::make('Settings')
                    ->schema([
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->label('Display Order')
                            ->helperText('Lower numbers appear first'),
                    ]),
            ]);
    }
}
