<?php

namespace App\Services\Calculator;

use App\Models\Calculator;
use Illuminate\Contracts\Container\BindingResolutionException;

trait CalculatorFrequent
{
    /**
     * Возвращает сервис калькуляторов
     * @param Calculator|null $calculator
     * @return CalculatorService
     * @throws BindingResolutionException
     */
    private function calculatorService(?Calculator $calculator): CalculatorService
    {
        return app()->make(CalculatorService::class, [
            'calculator' => $calculator ?? null,
        ]);
    }
}
