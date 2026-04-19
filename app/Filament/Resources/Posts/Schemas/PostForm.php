<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * PostForm
 *
 * Form schema configuration for creating and editing blog posts.
 */
class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Post Content')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->label('Title')
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->label('Slug')
                            ->helperText('URL-friendly version of the title')
                            ->maxLength(255),
                        Textarea::make('excerpt')
                            ->required()
                            ->label('Excerpt')
                            ->rows(3)
                            ->helperText('Short summary for listing cards')
                            ->columnSpanFull(),
                        Textarea::make('body')
                            ->required()
                            ->label('Content')
                            ->rows(10)
                            ->helperText('Full markdown content')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Media')
                    ->schema([
                        TextInput::make('cover_image')
                            ->label('Cover Image')
                            ->url()
                            ->placeholder('https://example.com/image.jpg')
                            ->columnSpanFull(),
                    ]),

                Section::make('Metadata')
                    ->schema([
                        TagsInput::make('tags')
                            ->label('Tags')
                            ->placeholder('Add tags')
                            ->columnSpanFull(),
                        TextInput::make('read_time')
                            ->numeric()
                            ->default(5)
                            ->label('Estimated Read Time (minutes)')
                            ->columnSpan(1),
                        Select::make('status')
                            ->required()
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->default('draft')
                            ->label('Status')
                            ->columnSpan(1),
                        DateTimePicker::make('published_at')
                            ->label('Published At')
                            ->columnSpan(1),
                    ])->columns(3),
            ]);
    }
}
