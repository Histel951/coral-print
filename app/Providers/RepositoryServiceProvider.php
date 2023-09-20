<?php

namespace App\Providers;

use App\Repositories\Color\ColorPaintRepository;
use App\Repositories\Color\ColorPaintRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ColorPaintRepositoryInterface::class, ColorPaintRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
