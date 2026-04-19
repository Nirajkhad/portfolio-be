<?php

namespace App\Filament\Resources\Experiences\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 * ExperiencesTable
 *
 * Table schema configuration for displaying work experiences.
 */
class ExperiencesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company')
                    ->label('Company')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('role')
                    ->label('Position')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('employment_type')
                    ->label('Type')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('start_date')
                    ->label('Start')
                    ->date('M Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('end_date')
                    ->label('End')
                    ->date('M Y')
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_current')
                    ->label('Current')
                    ->boolean()
                    ->toggleable(),
                TextColumn::make('location')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('bullets')
                    ->label('Bullets')
                    ->formatStateUsing(fn ($state) => $state->count())
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
