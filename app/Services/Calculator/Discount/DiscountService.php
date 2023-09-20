<?php

namespace App\Services\Calculator\Discount;

use App\Models\Calculator;
use App\Services\Calculator\CalculatorType;
use App\Services\Calculator\Count\Algorithms\Calculator as CalculatedCalculator;

/**
 * Вызывает алгоритм подсчёта скидки в зависимости от типа калькулятора
 * @package DiscountService
 */
class DiscountService implements CalculatorDiscountInterface
{
    /**
     * @param Calculator $calculator
     */
    public function __construct(private readonly Calculator $calculator)
    {
    }

    /**
     * Инициализирует и возвращает результат подсчёта скидки в зависимости от калькулятора
     * @param CalculatedCalculator|array $calculator
     * @param int $productCount
     * @param object|array $parameters
     * @param float $minPrice
     * @return array
     */
    public function get(
        CalculatedCalculator|array $calculator,
        int $productCount,
        object|array $parameters = [],
        float $minPrice = 0,
    ): array {
        $instance = $this->getInstanceByTypeName(CalculatorType::from($this->calculator->calculatorType->name));

        return $instance->get($calculator, $productCount, $parameters, $minPrice);
    }

    /**
     * Ищет нужный класс по типу калькулятора
     * @param CalculatorType $calculatorType
     * @return CalculatorDiscountInterface
     */
    private function getInstanceByTypeName(CalculatorType $calculatorType): CalculatorDiscountInterface
    {
        return match ($calculatorType) {
            CalculatorType::BusinessCards => new BusinessCardsDiscountService($this->calculator),
            CalculatorType::Catalogs => new CatalogDiscountService($this->calculator),
            default => new CalculatorDiscountService(),
        };
    }
}
