<?php

namespace App\Services\Calculator\Config;

use App\Models\Calculator;
use App\Services\Calculator\CalculatorFieldService;
use App\Services\Calculator\CalculatorRouteService;
use App\Services\TooltipService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;

/**
 * Подтягивает конфиг о калькуляторе с учётом cover и block подкалькуляторов (если есть)
 * @package CalculatorCatalogConfig
 */
class CalculatorCatalogConfig implements CalculatorConfigInterface
{
    use ConfigClear;

    /**
     * Основной переданный калькулятор
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
        $validators =
            $this->calculator
                ->configs()
                ->where('name', 'validators')
                ->first()->value ?? [];

        $materialService = new CalculatorMaterialService($this->calculator);
        $fieldsService = new CalculatorFieldService($this->calculator);
        $routeService = new CalculatorRouteService($this->calculator);
        $tooltipService = new TooltipService($this->calculator);

        return $this->configBuilder
            ->standard(
                calculator: $this->calculator,
                fields: $fieldsService->fields(),
                routes: $routeService->getRoutes($materialService->designPrices()),
                data: $this->getData($materialService, $this->calculator->calculatorSubs()->get()),
                validators: $validators,
                checkboxes: $fieldsService->checkboxes(),
                tooltips: $tooltipService->getTooltips(),
            )
            ->getConfig();
    }

    /**
     * Формирует массив данных для полей
     * @param CalculatorMaterialService $materialService
     * @param Collection $subCalculators
     * @return array
     */
    private function getData(CalculatorMaterialService $materialService, Collection $subCalculators): array
    {
        $fieldsData['block_select'] = (new CalculatorSelectBlockConfig($this->calculator))->get();
        $fieldsData['sprint_position'] = $materialService->sprintPosition();
        $fieldsData['width-height'] = $materialService->widthHeight();
        $fieldsData['page_count'] = $materialService->pageCount();

        foreach ($subCalculators as $calculatorSub) {
            if ($calculatorSub) {
                $subMaterialService = new CalculatorMaterialService($calculatorSub);
                $fieldsData["print_type_{$calculatorSub->name}_select"] = $subMaterialService->prints();
                $fieldsData["color_{$calculatorSub->name}_select"] = $subMaterialService->chroma(
                    calculator: $this->calculator,
                );
                $fieldsData["material_{$calculatorSub->name}_select"] = $subMaterialService->materials([
                    'calculator' => $this->calculator,
                ]);
                $fieldsData["lam_{$calculatorSub->name}_select"] = $subMaterialService->laminations([
                    'calculator' => $this->calculator,
                ]);
                $fieldsData["foiling_{$calculatorSub->name}_select"] = $subMaterialService->foilings(
                    calculator: $this->calculator,
                );
                $fieldsData["plastic_{$calculatorSub->name}_select"] = $subMaterialService->plastic(
                    calculator: $this->calculator,
                );
                $fieldsData["bolt_{$calculatorSub->name}_select"] = $subMaterialService->bolts(
                    calculator: $this->calculator,
                );
            }
        }

        return $fieldsData;
    }
}
