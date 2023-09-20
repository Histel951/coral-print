<?php

namespace App\Services;

interface CustomConfigs
{
    /**
     * Устанавливает значение для конфига
     * @param string $name
     * @param string $value
     * @return void
     */
    public function set(string $name, mixed $value): void;

    /**
     * Получение значения конфига
     * @param string $name
     * @return mixed
     */
    public function get(string $name): mixed;
}
