<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

abstract class UserRecordPage extends Page
{
    use InteractsWithRecord;

    protected static string $resource = UserResource::class;

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        abort_unless(static::getResource()::canEdit($this->getRecord()), 403);
    }

    public function getRecord(): User
    {
        $record = $this->record;

        abort_unless($record instanceof User, 404);

        return $record;
    }

    /**
     * @param  array<string, mixed>  $parameters
     */
    public static function shouldRegisterNavigation(array $parameters = []): bool
    {
        $record = $parameters['record'] ?? null;

        if ($record === null) {
            return false;
        }

        return static::getResource()::canEdit($record);
    }
}
