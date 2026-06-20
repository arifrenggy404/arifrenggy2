<?php

namespace App\Filament\Resources\Messages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->disabled()
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->disabled()
                    ->required(),
                Textarea::make('message')
                    ->disabled()
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
