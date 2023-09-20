<?php

namespace App\Services\Calculator;

use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Services\Calculator\Config\BookletMaterialService;
use App\Services\Calculator\Config\CalculatorConfigInterface;
use App\Services\Calculator\Config\CalculatorConfigService;
use App\Services\Calculator\Config\CalculatorMaterialService;
use App\Services\Calculator\Config\MaterialService;
use App\Services\Calculator\Config\TagLabelMaterialService;
use App\Services\Calculator\Count\CalculatorCount;
use App\Services\Calculator\Count\CalculatorCountService;
use Generator;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Cache;
use App\Services\Calculator\CalculatorType as CalculatorTypeE;

/**
 * Общий фасад для всех сервисов калькуляторов
 *
 * @package CalculatorService
 */
final class CalculatorService
{
    /**
     * @param Calculator|null $calculator - модель калькулятора
     */
    public function __construct(private readonly ?Calculator $calculator)
    {
    }

    /**
     * Возвращает все калькуляторы, если передать 1 калькулятор, то он выведется на страницу, при
     * передаче в параметры типа, выведутся все и переданный калькулятор станет активным
     * @param CalculatorType|null $calculatorType
     * @return array<iterable>
     */
    public function types(?CalculatorType $calculatorType = null): array
    {
        return (new CalculatorTypeService($this->calculator, $calculatorType))();
    }

    /**
     * Возвращает сервис конфигов калькулятора для vue в зависимости от его типа
     * @return CalculatorConfigInterface
     * @throws BindingResolutionException
     */
    public function config(): CalculatorConfigInterface
    {
        return (new CalculatorConfigService($this->calculator))();
    }

    /**
     * @throws BindingResolutionException
     */
    public function configsByIds(array $calculators): array
    {
        $cacheKey = cache_key('calculator:service:configs', $calculators);
        $cache = Cache::tags(['calculator', 'service', 'configs']);

        if ($cache->has($cacheKey)) {
            return $cache->get($cacheKey);
        }

        $configs = iterator_to_array($this->getConfigs($calculators));

        $cache->put($cacheKey, $configs, now()->addHour());

        return $configs;
    }

    /**
     * Возвращает сервис подсчёта цены печати
     * @return CalculatorCount
     * @throws BindingResolutionException
     */
    public function count(): CalculatorCount
    {
        return (new CalculatorCountService($this->calculator))();
    }

    /**
     * Возвращает сервис, который формирует массив материалов для конфигов
     * @return MaterialService
     */
    public function material(): MaterialService
    {
        return match (CalculatorTypeE::from($this->calculatorTypeName())) {
            CalculatorTypeE::Booklets => new BookletMaterialService($this->calculator),
            CalculatorTypeE::labelsTag => new TagLabelMaterialService($this->calculator),
            default => new CalculatorMaterialService($this->calculator)
        };
    }

    /**
     * Возвращает сервис проверок для калькулятора
     * @return CalculatorCheckService
     * @throws BindingResolutionException|CalculatorServiceException
     */
    public function check(): CalculatorCheckService
    {
        return match (CalculatorTypeE::from($this->calculator->calculatorType->name)) {
            CalculatorTypeE::Booklets => new BookletCheckService($this->calculator),
            default => throw new CalculatorServiceException(
                message: "\"Checks\" class for type \"{$this->calculator->calculatorType->name}\" not found.",
            ),
        };
    }

    /**
     * @throws BindingResolutionException
     */
    private function getConfigs(array $calculators): Generator
    {
        foreach ($calculators as $calculator) {
            $currentCalculator = Calculator::query()
                ->where('id', $calculator['id'])
                ->get()
                ->first();

            $config = (new CalculatorConfigService($currentCalculator))()->get([
                'print_type' => $calculator['print_type'],
                'white_print' => $calculator['white_print'],
            ]);

            $config['id'] = $calculator['id'];
            $config['calculator_type'] = $currentCalculator->calculatorType->name;
            $config['name'] = $currentCalculator->name;
            $config['design_services'] = $config['formSchema']['routes']['mockupsUpload']['services']['design'];
            $config['print_type'] = $calculator['print_type'];
            $config['white_print'] = $calculator['white_print'];
            unset($config['formSchema']);

            yield $config;
        }
    }

    /**
     * Возвращает имя калькулятора для подсчёта
     * @return string
     */
    private function calculatorTypeName(): string
    {
        return $this->calculator->calculatedCalculatorType?->name
            ?? $this->calculator->calculatorType?->name;
    }
}
