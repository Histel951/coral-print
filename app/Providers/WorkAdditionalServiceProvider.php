<?php

namespace App\Providers;

use App\Services\Calculator\Count\Algorithms\Calculator;
use App\Services\Calculator\WorkAdditionalService;
use Illuminate\Support\ServiceProvider;

class WorkAdditionalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(WorkAdditionalService::class, static fn () => new WorkAdditionalService());
    }

    /**
     * Bootstrap services.
     * @return void
     */
    public function boot(WorkAdditionalService $workAdditionalService): void
    {
        WorkAdditionalService::macro('setCalculatorWorks', function (
            Calculator &$calculator,
            array $whereParams = [],
            int $times = null,
            float $coefficient = 1,
        ) use ($workAdditionalService): void {
            $workAdditionalService->setWorks($calculator, $whereParams, $times, $coefficient);
        });
    }
}
