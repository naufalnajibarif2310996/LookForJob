<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\JobScraper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(JobScraper::class, function ($app) {
            return new JobScraper();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

}
