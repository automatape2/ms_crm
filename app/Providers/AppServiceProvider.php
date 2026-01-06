<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configure Livewire for subdirectory deployment
        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('livewire/update', $handle);
        });
        
        Livewire::setScriptRoute(function ($handle) {
            return Route::get('livewire/livewire.js', $handle);
        });
    }
}
