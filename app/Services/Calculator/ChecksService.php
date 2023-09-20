<?php

namespace App\Services\Calculator;

use App\Models\Check;

interface ChecksService
{
    /**
     * Проверяет равны ли переданные значения $values с значениями из базы
     * @param Check $check
     * @param array $values
     * @return bool
     */
    public function equalOr(Check $check, array $values): bool;
}
