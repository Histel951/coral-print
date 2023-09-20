<?php

namespace App\Services\Calculator\Count;

interface CalculatorCount
{
    /**
     * Подсчитывает стоимость печати для калькулятора с выбранными параметрами
     * @return mixed
     */
    public function get(): array;
}
