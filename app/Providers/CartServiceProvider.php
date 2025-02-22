<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\CartRepositoryInterface;
use App\Services\CartService;
class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CartService::class, function($app){
            return new CartService($app->make(CartRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
