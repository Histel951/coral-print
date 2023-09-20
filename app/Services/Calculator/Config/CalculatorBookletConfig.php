<?php

namespace App\Services\Calculator\Config;

use App\Models\Calculator;
use App\Services\Calculator\CalculatorFieldService;
use App\Services\Calculator\CalculatorRouteService;
use App\Services\TooltipService;
use Illuminate\Contracts\Container\BindingResolutionException;

class CalculatorBookletConfig implements CalculatorConfigInterface
{
    /**
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

    public function get(): array
    {
        $fieldsService = new CalculatorFieldService($this->calculator);
        $routeService = new CalculatorRouteService($this->calculator);
        $materialService = new BookletMaterialService($this->calculator);
        $tooltipService = new TooltipService($this->calculator);

        return $this->configBuilder
            ->standard(
                calculator: $this->calculator,
                fields: $fieldsService->fields(),
                routes: $routeService->getRoutes($materialService->designPrices()),
                data: $this->getData($materialService),
                checkboxes: $fieldsService->checkboxes(),
                tooltips: $tooltipService->getTooltips(),
            )
            ->getConfig();
    }

    private function getData(CalculatorMaterialService $materialService): array
    {
        $fieldsData['material'] = $materialService->materials();
        $fieldsData['lam'] = $materialService->laminations();
        $fieldsData['print_select'] = $this->calculator->colors->toArray();
        $fieldsData['width-height'] = $materialService->widthHeight();
        $fieldsData['fold_count'] = $this->calculator->colorCounts;
        $fieldsData['foiling'] = $materialService->foilings();

        return $fieldsData;
    }
}
