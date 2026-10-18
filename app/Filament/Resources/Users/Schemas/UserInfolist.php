<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Main profile')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('email')
                            ->label('Email address'),
                        TextEntry::make('email_verified_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ]),
                Section::make('Two-factor authentication')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('two_factor_secret')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('two_factor_recovery_codes')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('two_factor_confirmed_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
