<?php

namespace App\Providers;

use App\Services\Calculator\CalculatorDepsInterface;
use App\Services\Calculator\CalculatorDepsService;
use App\Services\Calculator\CalculatorFieldService;
use App\Services\Calculator\CalculatorModelTextMessageService;
use App\Services\Calculator\CalculatorPreviewService;
use App\Services\Calculator\CalculatorRoute;
use App\Services\Calculator\CalculatorRouteService;
use App\Services\Calculator\CalculatorService;
use App\Services\Calculator\Config\CalculatorMaterialService;
use App\Services\Calculator\Config\MaterialService;
use App\Services\Calculator\Count\Util\CalculatorRestrictionSizeChecker;
use App\Services\Calculator\Count\Util\RestrictionSizeChecker;
use App\Services\Calculator\Discount\CalculatorDiscountInterface;
use App\Services\Calculator\Discount\DiscountService;
use App\Services\Calculator\FieldsService;
use App\Services\Calculator\PreviewService;
use App\Services\ModelTextMessage;
use App\Services\Tooltip;
use App\Services\TooltipService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class CalculatorServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(RestrictionSizeChecker::class, CalculatorRestrictionSizeChecker::class);
        $this->app->bind(CalculatorDiscountInterface::class, DiscountService::class);
        $this->app->bind(PreviewService::class, CalculatorPreviewService::class);
        $this->app->bind(CalculatorService::class, CalculatorService::class);
        $this->app->bind(FieldsService::class, CalculatorFieldService::class);
        $this->app->bind(Tooltip::class, TooltipService::class);
        $this->app->bind(CalculatorRoute::class, CalculatorRouteService::class);
        $this->app->bind(MaterialService::class, CalculatorMaterialService::class);
        $this->app->bind(ModelTextMessage::class, CalculatorModelTextMessageService::class);
        $this->app->bind(CalculatorDepsInterface::class, CalculatorDepsService::class);
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

    public function provides(): array
    {
        return [
            CalculatorDiscountInterface::class,
            PreviewService::class,
            CalculatorService::class,
            RestrictionSizeChecker::class,
            FieldsService::class,
            Tooltip::class,
            CalculatorRoute::class,
            MaterialService::class,
            ModelTextMessage::class,
            CalculatorDepsInterface::class,
        ];
    }
}
