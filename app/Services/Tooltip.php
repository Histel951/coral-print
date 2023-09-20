<?php

namespace App\Services;

interface Tooltip
{
    /**
     * Возвращает подсказки
     * @return array
     */
    public function getTooltips(): array;
}
