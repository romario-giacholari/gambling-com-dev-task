<?php

namespace App\Providers;

use App\Services\AffiliatesFileReader\AffiliatesFileReader;
use App\Services\AffiliatesFileReader\IAffiliatesFileReader;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(IAffiliatesFileReader::class, AffiliatesFileReader::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
