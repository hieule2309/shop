<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\CartRepositoryInterface;
use App\Repositories\CartRepository;

class CartRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
