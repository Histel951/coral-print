<?php

declare(strict_types=1);

namespace App\Services\Calculator\Config;

use App\Models\Calculator;
use App\Services\Calculator\CalculatorDepsInterface;
use App\Services\Calculator\CalculatorRoute;
use App\Services\Calculator\FieldsService;
use App\Services\Calculator\PreviewService;
use App\Services\Tooltip;
use App\Models\PrintModel;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Формирует массив конфигов для калькулятора Vue с типом "Наклейки"
 * @package CalculatorStickersConfig
 */
class CalculatorStickersConfig implements CalculatorConfigInterface
{
    use ConfigClear;

    /**
     * Калькулятор для подтягивания и формирования конфигов
     * @var Calculator
     */
    private Calculator $calculator;

    /**
     * Получение превью калькулятора
     * @var PreviewService|mixed
     */
    private PreviewService $previewService;

    /**
     * Формирование зависимостей для калькулятора
     * @var CalculatorDepsInterface
     */
    private readonly CalculatorDepsInterface $calculatorDeps;

    /**
     * Подсказки
     * @var Tooltip
     */
    private readonly Tooltip $tooltip;

    /**
     * Роуты калькулятора
     * @var CalculatorRoute
     */
    private readonly CalculatorRoute $calculatorRoute;

    /**
     * Получение материалов калькулятора
     * @var CalculatorMaterialService
     */
    private readonly CalculatorMaterialService $materialService;

    /**
     * Поля калькулятора
     * @var FieldsService
     */
    private readonly FieldsService $fields;

    /**
     * Формирует массив конфигов для калькулятора
     * @var ConfigBuilder
     */
    private readonly ConfigBuilder $configBuilder;

    /**
     * @param Calculator $calculator
     * @throws BindingResolutionException
     */
    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
        $this->previewService = app()->make(PreviewService::class);
        $this->calculatorDeps = app()->make(CalculatorDepsInterface::class);

        $this->tooltip = app()->make(Tooltip::class, [
            'calculator' => $calculator,
        ]);

        $this->calculatorRoute = app()->make(CalculatorRoute::class, [
            'calculator' => $calculator,
        ]);

        $this->materialService = app()->make(CalculatorMaterialService::class, [
            'calculator' => $calculator,
        ]);

        $this->fields = app()->make(FieldsService::class, [
            'calculator' => $calculator,
        ]);

        $this->configBuilder = app()->make(ConfigBuilder::class);
    }

    /**
     * Возвращает сформированный массив конфигов
     * @param array $parameters - например какие-то параметры из контроллера (из запроса)
     * @return array
     */
    public function get(array $parameters = []): array
    {
        return $this->configBuilder
            ->standard(
                calculator: $this->calculator,
                fields: $this->fields->fields(),
                checkboxes: $this->fields->checkboxes(),
                routes: $this->calculatorRoute->getRoutes($this->materialService->designPrices()),
                data: $this->getData($parameters),
                deps: isset($this->calculator->parameters['is_deps_data']) &&
                $this->calculator->parameters['is_deps_data']
                    ? $this->deps()
                    : [],
                tooltips: $this->tooltip->getTooltips(),
            )
            ->getConfig();
    }

    /**
     * Формирование массива с данными для полей
     * @param array $parameters
     * @return array
     */
    private function getData(array $parameters = []): array
    {
        $fieldsData = [];
        $fieldsData['print_type'] = $this->materialService->prints();
        $fieldsData['cutting'] = $this->materialService->cuttings();
        $fieldsData['width-height'] = $this->calculator->calculatorType?->printSizes ?? [];
        $fieldsData['lam'] = $this->materialService->laminations([
            'print_type' => $parameters['print_type'] ?? null,
        ]);
        $fieldsData['foiling'] = $this->materialService->foilings();
        $fieldsData['material'] = $this->materialService->materials([
            'print_type' => $parameters['print_type'] ?? null,
            'white_print' => $parameters['white_print'] ?? null,
        ]);
        $fieldsData['form'] = $this->materialService->forms();

        return $fieldsData;
    }

    /**
     * Подтягивает зависимости полей
     * @return array[]
     */
    private function deps(): array
    {
        $calculatorPrintSpecies = $this->calculator->prints;

        $hasWhitePrint =
            isset($this->calculator->parameters['has_white_print']) && $this->calculator->parameters['has_white_print'];
        $hasVolume = isset($this->calculator->parameters['has_volume']) && $this->calculator->parameters['has_volume'];

        $calculatorPrintSpecies->each(function (PrintModel $print) use ($hasWhitePrint, $hasVolume) {
            $condition = ['print_type' => $print->id];

            if ($hasWhitePrint) {
                $this->calculatorDeps->setDep(
                    conditions: ['white_print' => 1, ...$condition],
                    data: $this->materialService->materials(['white_print' => 1, ...$condition]),
                    changedFieldName: 'material',
                );

                $this->calculatorDeps->setDep(
                    conditions: ['white_print' => 0, ...$condition],
                    data: $this->materialService->materials(['white_print' => 0, ...$condition]),
                    changedFieldName: 'material',
                );
            }

            if ($hasVolume) {
                $this->calculatorDeps->setDep(
                    conditions: ['volume' => 1],
                    data: $this->materialService->cuttings(true),
                    changedFieldName: 'cutting',
                );

                $this->calculatorDeps->setDep(
                    conditions: ['volume' => 0],
                    data: $this->materialService->cuttings(),
                    changedFieldName: 'cutting',
                );
            }

            $this->calculatorDeps->setDep(
                conditions: $condition,
                data: $this->materialService->materials($condition),
                changedFieldName: 'material',
            );

            $this->calculatorDeps->setDep(
                conditions: $condition,
                data: $this->materialService->laminations($condition),
                changedFieldName: 'lam',
            );
        });

        return $this->calculatorDeps->get();
    }
}
