<?php

namespace App\Services\Calculator;

use App\Models\Calculator;

interface PreviewService
{
    /**
     * Возвращает массив превью продукта калькулятора
     * @param Calculator $calculator
     * @param array $whereParams
     * @return mixed
     */
    public function get(Calculator $calculator, array $whereParams = []): array;
}
