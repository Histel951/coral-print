<?php

namespace App\Services;

use App\Models\Check;
use App\Services\Calculator\ChecksService;

class DefaultChecksService implements ChecksService
{
    /**
     * Проверяет равны ли переданные значения $values с значениями из базы
     * Значение считается верным если равно определённому точному значению, или является одним из коллекции значений
     * @param Check $check
     * @param array $values
     * @return bool
     */
    public function equalOr(Check $check, array $values): bool
    {
        foreach ($values as $key => $value) {
            if (!key_exists($key, $check->checks)) {
                continue;
            }

            if (is_array($check->checks[$key]) && !in_array($value, $check->checks[$key])) {
                return false;
            }

            if (!is_array($check->checks[$key]) && $value !== $check->checks[$key]) {
                return false;
            }
        }

        return true;
    }
}
