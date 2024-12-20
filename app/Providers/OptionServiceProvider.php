<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\OptionRepositoryInterface;
use App\Repositories\OptionRepository;

class OptionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(OptionRepositoryInterface::class, OptionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
