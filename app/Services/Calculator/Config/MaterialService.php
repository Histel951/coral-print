<?php

namespace App\Services\Calculator\Config;

interface MaterialService
{
    /**
     * Возвращает список материалов
     * @param array $parameters
     * @param array $whereParams
     * @return array
     */
    public function materials(array $parameters = [], array $whereParams = []): array;

    /**
     * Возвращает список ламинаций
     * @param array $parameters
     * @return array
     */
    public function laminations(array $parameters = []): array;

    /**
     * Возвращает цены на дизайн
     * @return array
     */
    public function designPrices(): array;

    /**
     * Возвращает массив валидаторов для vue
     * @return array
     */
    public function validators(): array;
}
