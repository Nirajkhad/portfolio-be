<?php

namespace App\Filament\Resources\GeneralInfos;

use App\Filament\Resources\GeneralInfos\Pages\ManageGeneralInfos;
use App\Models\GeneralInfo;
use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GeneralInfoResource extends Resource
{
    protected static ?string $model = GeneralInfo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'GeneralInfo';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identity')
                    ->schema([
                        TextInput::make('full_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('title')
                            ->required()
                            ->placeholder('Backend Software Engineer')
                            ->maxLength(255),
                    ])->columns(2),

                Section::make('Contact')
                    ->schema([
                        TextInput::make('email')
                            ->email()
                            ->required(),
                        TextInput::make('phone')
                            ->nullable(),
                        TextInput::make('location')
                            ->nullable()
                            ->placeholder('Kathmandu, Nepal'),
                    ])->columns(3),

                Section::make('Social Links')
                    ->schema([
                        Repeater::make('socialLinks')
                            ->relationship()
                            ->schema([
                                TextInput::make('platform')
                                    ->required()
                                    ->placeholder('GitHub')
                                    ->columnSpanFull(),
                                TextInput::make('url')
                                    ->url()
                                    ->required()
                                    ->placeholder('https://github.com/username')
                                    ->columnSpanFull(),
                                TextInput::make('icon')
                                    ->placeholder('fab fa-github')
                                    ->helperText('Optional: Icon class for frontend (e.g., fab fa-github, fab fa-linkedin)')
                                    ->columnSpan(1),
                                TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Order of display')
                                    ->columnSpan(1),
                            ])
                            ->columns(2)
                            ->orderColumn('sort_order')
                            ->addActionLabel('+ Add social link')
                            ->defaultItems(0)
                            ->collapsed()
                            ->itemLabel(fn (array $state): ?string => $state['platform'] ?? null)
                            ->columnSpanFull(),
                    ]),

                Section::make('Settings')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active Portfolio')
                            ->default(true)
                            ->helperText('Only active records will be served by the API.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Bio')
                    ->schema([
                        Textarea::make('bio')
                            ->rows(5)
                            ->placeholder('A passionate backend software engineer with 3 years of experience...')
                            ->maxLength(1000),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->columns([
                TextColumn::make('full_name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('location')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('socialLinks')
                    ->label('Social Links')
                    ->formatStateUsing(fn ($state) => $state->count())
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
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

    public static function getPages(): array
    {
        return [
            'index' => ManageGeneralInfos::route('/'),
        ];
    }
}
