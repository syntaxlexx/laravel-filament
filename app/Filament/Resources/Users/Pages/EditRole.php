<?php

namespace App\Filament\Resources\Users\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class EditRole extends UserRecordPage
{
    protected static ?string $navigationLabel = 'Edit Role';

    protected static ?string $title = 'Edit Role';

    protected static ?int $navigationSort = 4;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Role')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required(),
                    ]),
            ]);
    }
}
