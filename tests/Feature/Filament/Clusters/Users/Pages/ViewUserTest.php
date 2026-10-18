<?php

use App\Filament\Resources\Users\Pages\AccountStatus;
use App\Filament\Resources\Users\Pages\EditRole;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Models\User;
use Livewire\Livewire;

test('users list stays on the users resource route', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    expect(parse_url(ListUsers::getUrl(), PHP_URL_PATH))->toBe('/admin/users');
});

test('view action opens the user profile', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(ListUsers::class)
        ->assertTableActionHasUrl('view', ViewUser::getUrl(['record' => $user]), $user);
});

test('user profile sidebar links to each profile page', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(ViewUser::class, ['record' => $user->getKey()])
        ->assertSee('Main profile')
        ->assertSee('Account Status')
        ->assertSee('Edit Role')
        ->assertSee(parse_url(AccountStatus::getUrl(['record' => $user]), PHP_URL_PATH))
        ->assertSee(parse_url(EditRole::getUrl(['record' => $user]), PHP_URL_PATH));
});

test('edit role page shows the profile sidebar', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(EditRole::class, ['record' => $user->getKey()])
        ->assertSee('Main profile')
        ->assertSee('Account Status')
        ->assertSee('Edit Role');
});

test('account status page shows the profile sidebar', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(AccountStatus::class, ['record' => $user->getKey()])
        ->assertSee('Main profile')
        ->assertSee('Edit profile')
        ->assertSee(parse_url(ViewUser::getUrl(['record' => $user]), PHP_URL_PATH));
});

test('account status form saves the email verification time', function () {
    $user = User::factory()->unverified()->create();
    $verifiedAt = now()->startOfMinute();

    $this->actingAs($user);

    Livewire::test(AccountStatus::class, ['record' => $user->getKey()])
        ->fillForm([
            'email_verified_at' => $verifiedAt->toDateTimeString(),
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($user->refresh()->email_verified_at?->toDateTimeString())->toBe($verifiedAt->toDateTimeString());
});

test('account status form clears email verification', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(AccountStatus::class, ['record' => $user->getKey()])
        ->fillForm([
            'email_verified_at' => null,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($user->refresh()->email_verified_at)->toBeNull();
});
