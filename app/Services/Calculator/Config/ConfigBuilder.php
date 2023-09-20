<?php

namespace App\Services\Calculator\Config;

use App\Models\Calculator;

/**
 * Формирует стандартный массив конфигов
 * phpcs:ignore
 * @method self standard(Calculator $calculator, array $fields = [], array $checkboxes = [], array $routes = [], array $data = [], array $deps = [], array $validators = [],array $tooltips = [])
 */
interface ConfigBuilder
{
    /**
     * Возвращает сформированный массив конфигов
     * @return array
     */
    public function getConfig(): array;
}
