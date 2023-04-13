<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\StockServiceInterface;
use App\Services\StockService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(StockServiceInterface::class, StockService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
