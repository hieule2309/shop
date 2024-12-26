<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\OptionRepositoryInterface;
use App\Interfaces\OptionAttributeRepositoryInterface;
use App\Models\OptionAttribute;
use App\Models\Product;
use App\Services\ProductService;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProductService::class, function($app){
            return new ProductService(
                $app->make(ProductRepositoryInterface::class),
                $app->make(CategoryRepositoryInterface::class),
                $app->make(OptionRepositoryInterface::class),
                $app->make(OptionAttributeRepositoryInterface::class)
            );
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
