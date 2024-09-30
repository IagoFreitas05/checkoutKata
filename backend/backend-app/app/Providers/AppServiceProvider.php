<?php

namespace App\Providers;

use App\adapter\businessUseCases\MultipricedPromotionImpl;
use App\business\usecases\MultipricedPromotionUseCase;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MultipricedPromotionUseCase::class, MultipricedPromotionImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
