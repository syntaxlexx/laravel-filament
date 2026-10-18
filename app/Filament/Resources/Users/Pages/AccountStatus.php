<?php

namespace App\Filament\Resources\Users\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

/**
 * @property-read Schema $form
 */
class AccountStatus extends UserRecordPage
{
    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    protected static ?string $navigationLabel = 'Account Status';

    protected static ?string $title = 'Account Status';

    protected static ?int $navigationSort = 3;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        $this->form->fill([
            'email_verified_at' => $this->getRecord()->email_verified_at,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DateTimePicker::make('email_verified_at')
                    ->label('Email verified at'),
            ]);
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema
            ->model($this->getRecord())
            ->operation('edit')
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $record = $this->getRecord();
        $record->email_verified_at = $data['email_verified_at'] ?: null;
        $record->save();

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Account Status')
                    ->schema([
                        Form::make([
                            EmbeddedSchema::make('form'),
                        ])
                            ->id('form')
                            ->livewireSubmitHandler('save')
                            ->footer([
                                Actions::make([
                                    Action::make('save')
                                        ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                                        ->submit('save')
                                        ->keyBindings(['mod+s']),
                                ])
                                    ->alignment($this->getFormActionsAlignment())
                                    ->key('form-actions'),
                            ]),
                    ]),
            ]);
    }
}
