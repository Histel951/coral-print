<?php

namespace App\Providers;

use App\Orchid\Custom\CustomTD;
use App\Repositories\Knifes\RapportKnifeRepository;
use App\Repositories\Knifes\RapportKnifeRepositoryInterface;
use App\Services\Calculator\ChecksService;
use App\Services\CustomConfigs;
use App\Services\CustomConfigsService;
use App\Services\DadataSuggestService;
use App\Services\DefaultChecksService;
use App\Services\RapportKnifeService;
use App\Services\RapportKnifeServiceInterface;
use Dadata\DadataClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Dashboard;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(ChecksService::class, DefaultChecksService::class);
        $this->app->singleton(CustomConfigs::class, CustomConfigsService::class);
        $this->app->bind(RapportKnifeServiceInterface::class, RapportKnifeService::class);
        $this->app->bind(RapportKnifeRepositoryInterface::class, RapportKnifeRepository::class);
        $this->app->singleton(DadataSuggestService::class, function () {
            $client = new DadataClient(Config::get('dadata.api_key'), Config::get('dadata.secret_key'));

            return new DadataSuggestService($client);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @param Dashboard $dashboard
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        CustomTD::macro('optionButtons', function (string $editRoute, Model $model) {
            return Group::make([
                Link::make('Редактировать')
                    ->icon('note')
                    ->route($editRoute, $model),
            ]);
        });

        $dashboard->registerResource('scripts', '/js/ckeditor4/ckeditor.js');
        $dashboard->registerResource('scripts', '/js/dashboard.js');
    }
}
