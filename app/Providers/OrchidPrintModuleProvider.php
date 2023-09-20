<?php

namespace App\Providers;

use App\Orchid\Module\Print\BreadCrumbsCookie;
use App\Orchid\Module\Print\PrintBreadCrumbs;
use Illuminate\Support\ServiceProvider;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Field;

class OrchidPrintModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        Link::macro('back', function (
            BreadCrumbsCookie $cookie,
            string $defaultRoute = '',
            array $defaultParameters = [],
        ): Field {
            $urlParams = PrintBreadCrumbs::get($cookie);

            if (isset($urlParams['name'])) {
                return Link::make('Назад')->route($urlParams['name'], $urlParams['parameters']);
            }

            return Link::make('Назад')->route($defaultRoute, $defaultParameters);
        });
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
