<?php

namespace App\Services\Calculator\Discount;

use App\Services\Calculator\Count\Algorithms\Calculator;

interface CalculatorDiscountInterface
{
    /**
     * Возвращает подсчитанные скидки для калькулятора
     * @param Calculator|array $calculator
     * @param int $productCount - изначальное количество продуктов печати
     * @param object|array $parameters - параметры передаваемые в getBeforeTotal
     * @param float $minPrice - минимальная цена печати калькулятора
     * @return array
     */
    public function get(
        Calculator|array $calculator,
        int $productCount,
        object|array $parameters = [],
        float $minPrice = 0,
    ): array;
}
