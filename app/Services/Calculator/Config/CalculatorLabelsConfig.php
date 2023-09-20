<?php

namespace App\Services\Calculator\Config;

use App\Models\Calculator;
use App\Services\Calculator\CalculatorFieldService;
use App\Services\Calculator\CalculatorRouteService;
use App\Services\TooltipService;
use Illuminate\Contracts\Container\BindingResolutionException;

class CalculatorLabelsConfig implements CalculatorConfigInterface
{
    use ConfigClear;

    /**
     * Калькулятор для подтягивания и формирования конфигов
     * @var Calculator
     */
    private Calculator $calculator;

    /**
     * Формирует массив конфигов
     * @var ConfigBuilder
     */
    private ConfigBuilder $configBuilder;

    /**
     * @param Calculator $calculator
     * @throws BindingResolutionException
     */
    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;

        $this->configBuilder = app()->make(ConfigBuilder::class);
    }

    /**
     * @inheritDoc
     */
    public function get(array $parameters = []): array
    {
        $fieldsService = new CalculatorFieldService($this->calculator);
        $routeService = new CalculatorRouteService($this->calculator);
        $materialService = new CalculatorMaterialService($this->calculator);
        $tooltipService = new TooltipService($this->calculator);
        $validators =
            $this->calculator
                ->configs()
                ->where('name', 'validators')
                ->first()->value ?? [];

        return $this->configBuilder
            ->standard(
                calculator: $this->calculator,
                fields: $fieldsService->fields(),
                routes: $routeService->getRoutes($materialService->designPrices()),
                data: $this->getData($materialService, $parameters),
                validators: $validators,
                checkboxes: $fieldsService->checkboxes(),
                tooltips: $tooltipService->getTooltips(),
            )
            ->getConfig();
    }

    private function getData(CalculatorMaterialService $materialService, array $parameters = []): array
    {
        $fieldsData = [];

        $fieldsData['print_type'] = $materialService->prints();
        $fieldsData['width-height'] = $this->calculator->calculatorType?->printSizes ?? [];
        $fieldsData['color'] = $this->calculator->colors;
        $fieldsData['material'] = $materialService->materials(['print_type' => $parameters['print_type'] ?? null]);
        $fieldsData['lam'] = $materialService->laminations();
        $fieldsData['foiling_face'] = $materialService->foilings();
        $fieldsData['hole'] = $this->calculator->holes;

        return $fieldsData;
    }
}
