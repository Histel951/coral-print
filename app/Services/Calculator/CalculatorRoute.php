<?php

namespace App\Services\Calculator;

interface CalculatorRoute
{
    /**
     * Формирует массив стандартный массив роутов
     * @param array $designPrices
     * @return array
     */
    public function getRoutes(array $designPrices = []): array;
}
