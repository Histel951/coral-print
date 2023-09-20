<?php

namespace App\Providers;

use App\Models\Calculator;
use App\Services\Calculator\Config\CalculatorConfigBuilderService;
use App\Services\Calculator\Config\ConfigBuilder;
use App\Services\Calculator\PreviewService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class CalculatorConfigServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(ConfigBuilder::class, CalculatorConfigBuilderService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        CalculatorConfigBuilderService::macro('standard', function (
            Calculator $calculator,
            array $fields,
            array $routes,
            array $data,
            array $validators = [],
            array $checkboxes = [],
            array $tooltips = [],
            array $deps = [],
        ): CalculatorConfigBuilderService {
            $this->setGeneralKey('formSchema');
            $this->put('fields', $fields);
            $this->put('checkboxes', $checkboxes);
            $this->put('validators', $validators);
            $this->put('routes', $routes);
            $this->put('calculator_id', $calculator->id);
            $this->put('tooltips', $tooltips);
            $this->put('min_price', $calculator->min_price);
            $this->put('deps', $deps);

            $previewsService = app()->make(PreviewService::class);
            $previewResult = $previewsService->get($calculator, [
                'calculator_id' => $calculator->id,
                'calculator_type_id' => $calculator->calculatorType?->id,
            ]);

            $this->put('previews', $previewResult);

            $this->setGeneralKey('data');
            $this->push($data);

            return $this;
        });
    }

    public function provides(): array
    {
        return [ConfigBuilder::class];
    }
}
