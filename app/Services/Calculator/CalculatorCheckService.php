<?php

namespace App\Services\Calculator;

interface CalculatorCheckService
{
    /**
     * Проверяет равны ли переданные значения $values с значениями из базы
     * @param string $fieldName
     * @param array $depsValues
     * @return bool
     */
    public function equalOr(string $fieldName, array $depsValues): bool;

    /**
     * Проверяет равны ли переданные значения $values с значениями из базы
     * Возвращает результат + данные для проверки
     * @param string $fieldName
     * @param array $depsValues
     * @return array
     */
    public function equalOrAndData(string $fieldName, array $depsValues): array;
}
