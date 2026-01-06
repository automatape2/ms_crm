<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        // Force root URL for subdirectory installations
        if (str_contains(config('app.url'), '/ms_crm')) {
            URL::forceRootUrl(config('app.url'));
        }
    }
}
