<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', App\Livewire\Dashboard::class)->name('dashboard');
    
    // Contacts
    Route::get('/contacts', App\Livewire\Contacts\Index::class)->name('contacts.index');
    Route::get('/contacts/create', App\Livewire\Contacts\Create::class)->name('contacts.create');
    Route::get('/contacts/{id}', App\Livewire\Contacts\Show::class)->name('contacts.show');
    
    // Organizations
    Route::get('/organizations', App\Livewire\Organizations\Index::class)->name('organizations.index');
    Route::get('/organizations/create', App\Livewire\Organizations\Create::class)->name('organizations.create');
    Route::get('/organizations/{id}', App\Livewire\Organizations\Show::class)->name('organizations.show');
    Route::get('/organizations/{id}/edit', App\Livewire\Organizations\Edit::class)->name('organizations.edit');
    
    // Campaigns
    Route::get('/campaigns', App\Livewire\Campaigns\Index::class)->name('campaigns.index');
    Route::get('/campaigns/create', App\Livewire\Campaigns\Create::class)->name('campaigns.create');
    Route::get('/campaigns/{id}', App\Livewire\Campaigns\Show::class)->name('campaigns.show');
    Route::get('/campaigns/{id}/edit', App\Livewire\Campaigns\Edit::class)->name('campaigns.edit');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
