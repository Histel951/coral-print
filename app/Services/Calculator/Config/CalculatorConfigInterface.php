<?php

namespace App\Services\Calculator\Config;

interface CalculatorConfigInterface
{
    /**
     * Возвращает сформированные конфиги для калькулятора
     * @return array
     */
    public function get(): array;
}
