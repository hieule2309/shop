<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\OptionAttributeRepositoryInterface;
use App\Interfaces\OptionRepositoryInterface;
use App\Repositories\OptionAttributeRepository;

class OptionAttributeRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(OptionAttributeRepositoryInterface::class, OptionAttributeRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
