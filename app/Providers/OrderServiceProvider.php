<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\OrderRepositoryInterface;
use App\Services\OrderService;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Binding cho OrderService
        $this->app->bind(OrderService::class, function ($app) {
            return new OrderService($app->make(OrderRepositoryInterface::class));
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
