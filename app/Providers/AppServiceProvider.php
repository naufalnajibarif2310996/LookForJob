<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Tidak ada binding JobScraper karena class-nya tidak ada
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}