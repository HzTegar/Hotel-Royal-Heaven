<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Pemesanan;
use App\Observers\PemesananObserver;

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
        Pemesanan::observe(PemesananObserver::class);
    }
}
