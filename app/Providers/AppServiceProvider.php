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
        if (config('app.env') === 'production') {
            Livewire::setUpdateRoute(function ($handle) {
                return Route::post('/ms_crm/livewire/update', $handle);
            });
            
            Livewire::setScriptRoute(function ($handle) {
                return Route::get('/ms_crm/livewire/livewire.js', $handle);
            });
        }
    }
}
