<?php

namespace App\Services\Calculator;

use Closure;
use Illuminate\Support\Collection;

interface CalculatorDepsInterface
{
    /**
     * Возвращает сформированный массив зависимостей для калькуляторов
     * @return array
     */
    public function get(): array;

    /**
     * Устанавливает значения для зависимостей
     * @param array $conditions - условия при которых происходит проверка на занчения
     * @param string $changedFieldName поле, данные которого будут меняться
     * @param array|Closure|Collection $data
     * @return void
     */
    public function setDep(array $conditions, array|Closure|Collection $data = [], string $changedFieldName = ''): void;
}
