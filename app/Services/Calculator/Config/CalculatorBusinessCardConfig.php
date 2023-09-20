<?php

namespace App\Services\Calculator\Config;

use App\Models\Calculator;
use App\Services\Calculator\CalculatorFieldService;
use App\Services\Calculator\CalculatorRouteService;
use App\Services\TooltipService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;

class CalculatorBusinessCardConfig implements CalculatorConfigInterface
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
                data: $this->getData($materialService, $this->calculator->calculatorSubs()->get(), $parameters),
                validators: $validators,
                checkboxes: $fieldsService->checkboxes(),
                tooltips: $tooltipService->getTooltips(),
            )
            ->getConfig();
    }

    private function getData(
        CalculatorMaterialService $materialService,
        Collection $calculatorSubs,
        array $parameters = [],
    ): array {
        $fieldsData = [];

        $fieldsData['print_type'] = $materialService->prints();
        $fieldsData['product_count'] = $this->getCountArr();
        $fieldsData['block_select'] = (new CalculatorSelectBlockConfig($this->calculator))->get();
        $fieldsData['lam'] = $materialService->laminations();
        $fieldsData['width-height'] = $this->calculator->calculatorType?->printSizes ?? [];
        $fieldsData['foiling_face'] = $materialService->foilings(face: true);
        $fieldsData['foiling_back'] = $materialService->foilings(face: false);
        $fieldsData['material'] = $materialService->materials([
            'print_type' => $parameters['print_type'] ?? null,
        ]);
        $fieldsData['form'] = $materialService->forms();
        $fieldsData['embossing_face'] = $this->calculator->embossings;
        $fieldsData['embossing_back'] = $this->calculator->embossings;
        $fieldsData['embossing_face2'] = $this->calculator->embossings;
        $fieldsData['embossing_back2'] = $this->calculator->embossings;
        $fieldsData['color_count_face'] = $this->calculator->colorCounts;
        $fieldsData['color_count_back'] = $this->calculator->colorCounts;
        $fieldsData['color_count_back_visitki_vip_back_select'] = $this->calculator->colorCounts;
        $fieldsData['color_count_face_visitki_vip_face_select'] = $this->calculator->colorCounts;
        $fieldsData['color'] = $this->calculator->colors;

        foreach ($calculatorSubs as $calculatorSub) {
            $materialServiceSub = new CalculatorMaterialService($calculatorSub);
            $foilings = $materialServiceSub->foilings(calculator: $this->calculator);

            $fieldsData["embossing_face1_select_{$calculatorSub->name}_select"] = $foilings;
            $fieldsData["embossing_back2_select_{$calculatorSub->name}_select"] = $foilings;
            $fieldsData["embossing_face2_select_{$calculatorSub->name}_select"] = $foilings;
            $fieldsData["embossing_back1_select_{$calculatorSub->name}_select"] = $foilings;
        }

        return $fieldsData;
    }

    private function getCountArr(): array
    {
        $counts = [50, 100, 200, 300, 400, 500, 1000];

        return array_map(fn ($v) => ['id' => $v, 'name' => $v], $counts);
    }
}
