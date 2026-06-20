<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, callable $set) => 
                        $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('summary')
                    ->required(),
                TagsInput::make('tags')
                    ->label('Tag Teknologi')
                    ->placeholder('Tambah teknologi...'),
                RichEditor::make('desc_content')
                    ->required()
                    ->columnSpanFull()
                    ->label('Deskripsi Proyek (Tab 1)'),
                RichEditor::make('arch_content')
                    ->columnSpanFull()
                    ->label('Arsitektur (Tab 2)'),
                RichEditor::make('code_content')
                    ->columnSpanFull()
                    ->label('Cuplikan Kode (Tab 3)'),
                FileUpload::make('image_path')
                    ->directory('projects')
                    ->image(),
                TextInput::make('github_url'),
                TextInput::make('demo_url'),
                Toggle::make('is_featured')
                    ->default(false),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
