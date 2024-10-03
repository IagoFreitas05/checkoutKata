<?php

namespace App\Providers;

use App\adapter\businessUseCases\BuyNGetOneFreePromotionImpl;
use App\adapter\businessUseCases\MealDealPromotionImpl;
use App\adapter\businessUseCases\MultipricedPromotionImpl;
use App\adapter\repository\ProductEloquentImplementation;
use App\adapter\repository\PromotionEloquentImplementation;
use App\business\repositories\Products;
use App\business\repositories\Promotions;
use App\business\usecases\BuyNGetOneFreePromotionUseCase;
use App\business\usecases\MealDealPromotionUseCase;
use App\business\usecases\MultipricedPromotionUseCase;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /* use cases */
        $this->app->bind(MultipricedPromotionUseCase::class, MultipricedPromotionImpl::class);
        $this->app->bind(MealDealPromotionUseCase::class, MealDealPromotionImpl::class);
        $this->app->bind(BuyNGetOneFreePromotionUseCase::class, BuyNGetOneFreePromotionImpl::class);

        /* repositories */
        $this->app->bind(Promotions::class, PromotionEloquentImplementation::class);
        $this->app->bind(Products::class, ProductEloquentImplementation::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
