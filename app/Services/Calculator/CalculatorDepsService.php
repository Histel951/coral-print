<?php

namespace App\Services\Calculator;

use Closure;
use Illuminate\Support\Collection;

/**
 * Формирует коллекцию зависимостей для калькуляторов, в зависимости от выбранных значений на фронте
 * меняет данные на фронте, от переданных параметров
 * @package CalculatorDepsService
 */
class CalculatorDepsService implements CalculatorDepsInterface
{
    /**
     * Зависимости
     * @var array
     */
    private array $depsValues = [];

    /**
     * Возвращает сформированный массив зависимостей для калькуляторов
     * @return array
     */
    public function get(): array
    {
        return $this->depsValues;
    }

    /**
     * Устанавливает значения для зависимостей
     * @param array $conditions - условия при которых происходит проверка на занчения
     * @param string $changedFieldName поле, данные которого будут меняться
     * @param array|Closure|Collection $data
     * @return void
     */
    public function setDep(array $conditions, array|Closure|Collection $data = [], string $changedFieldName = ''): void
    {
        if (!isset($this->depsValues[$changedFieldName])) {
            $this->depsValues[$changedFieldName] = [];
        }

        if ($data instanceof Closure) {
            $data = $data->call();
        }

        if ($changedFieldName) {
            $this->depsValues[$changedFieldName][] = [
                'conditions' => $conditions,
                'values' => $data,
            ];
        }
    }
}
