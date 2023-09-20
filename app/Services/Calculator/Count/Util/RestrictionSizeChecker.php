<?php

namespace App\Services\Calculator\Count\Util;

use App\Services\Calculator\Count\Util\Exceptions\PrintSizeException;

interface RestrictionSizeChecker
{
    /**
     * Проверяет допустимые размеры для печати
     * @param int $width
     * @param int $height
     * @param bool $useExtraMaxSize
     * @param bool $isNotPrintRotation - вращается ли печатный лист в зависимости от размеров
     * @return bool
     */
    public function check(
        int $width,
        int $height,
        bool $useExtraMaxSize = false,
        bool $isNotPrintRotation = false,
    ): bool;

    /**
     * Вызывает ошибку печати
     * @return void
     * @throws PrintSizeException
     */
    public function throwException(): void;
}
