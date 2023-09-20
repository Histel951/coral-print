<?php

namespace App\Services\Calculator;

interface FieldsService
{
    /**
     * Возвращают сформированный массив конфигов для полей
     * @return array
     */
    public function fields(): array;

    /**
     * Возвращают сформированный массив конфигов для чекбоксов
     * @return array
     */
    public function checkboxes(): array;
}
