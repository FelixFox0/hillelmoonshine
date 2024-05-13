<?php

namespace App\Providers;

use App\Repositories\ReserveRepository;
use App\Repositories\ReserveRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ReserveRepositoryInterface::class, ReserveRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
