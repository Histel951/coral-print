<?php

namespace App\Services\Calculator\Count\Util;

use App\Models\Calculator;
use App\Models\CalculatorRestriction;
use App\Models\SpecieType;
use App\Services\Calculator\Count\Util\Exceptions\PrintSizeException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Проверяет ограничения по допустимым размерам печати и максимальным/минимальным размерам калькулятора
 * @package CalculatorRestrictionSizeChecker
 */
class CalculatorRestrictionSizeChecker implements RestrictionSizeChecker
{
    /**
     * Ограничение содержащее в себе ->max_size && ->min_size
     * @var CalculatorRestriction|null
     */
    private readonly CalculatorRestriction|null $restriction;

    /**
     * Минимальный размер печати
     * @var int
     */
    private int $minRestrictionSize;

    /**
     * Максимально допустимный разимер печати
     * @var int
     */
    private int $maxRestrictionSize;

    /**
     * Использовать ли исключения при подсчёте допустимых размеров
     * @var bool
     */
    private bool $useExtraMaxSize = false;

    /**
     * Вращается ли печатный лист в зависимости от размеров
     * @var bool
     */
    private bool $isNotPrintRotation = false;

    /**
     * Вылет печати
     * @var int
     */
    private readonly int $departure;

    /**
     * Размер максимально возможной печати
     * @var int
     */
    private int $resultBiggerSize;

    /**
     * Передаваемая ширина
     * @var int
     */
    private int $width = 0;

    /**
     * Передаваемая высота
     * @var int
     */
    private int $height = 0;

    /**
     * @param Calculator|null $calculator калькулятор которого берутся ограничения размеров
     * @param SpecieType $print получение ограничений печати в зависимости от ширины/высоты
     */
    public function __construct(
        Calculator|null $calculator,
        private readonly SpecieType $print,
        int $departure,
        private readonly bool $isDuplexSize,
        private readonly bool $isNotUseDeparture,
    ) {
        $this->restriction = $calculator?->restrictions?->first();
        $this->maxRestrictionSize = $this->restriction?->max_size ?? 5000;
        $this->minRestrictionSize = $this->restriction?->min_size ?? 5;

        if (!$this->isNotUseDeparture) {
            $this->departure = $departure * 2;
        } else {
            $this->departure = 0;
        }
    }

    /**
     * Проверяет допустимые размеры для печати
     * @param int $width
     * @param int $height
     * @param bool $useExtraMaxSize
     * @param bool $isNotPrintRotation
     * @return bool
     */
    public function check(
        int $width,
        int $height,
        bool $useExtraMaxSize = false,
        bool $isNotPrintRotation = false,
    ): bool {
        $this->useExtraMaxSize = $useExtraMaxSize;
        $this->isNotPrintRotation = $isNotPrintRotation;
        $this->width = $width;
        $this->height = $height;

        if (!$isNotPrintRotation) {
            $maxPrint = max($this->print->width, $this->print->height);
            $minPrint = min($this->print->width, $this->print->height);
        } else {
            $maxPrint = $this->print->width;
            $minPrint = $this->print->height;
        }

        if (!$isNotPrintRotation) {
            $sizeBigger = max($height, $width);
            $sizeMin = min($height, $width);
        } else {
            $sizeBigger = $width;
            $sizeMin = $height;
        }

        if (!$minPrint || $useExtraMaxSize) {
            $this->resultBiggerSize = $this->getMax($this->maxRestrictionSize, $useExtraMaxSize);

            if ($useExtraMaxSize) {
                $resultMinSize = $this->resultBiggerSize;
            } else {
                $resultMinSize = $maxPrint - $this->departure;
            }
        } else {
            $departure = $this->departure;

            if ($this->isNotUseDeparture) {
                $departure = 0;
            }

            $this->resultBiggerSize = $this->getMax($maxPrint, $useExtraMaxSize) - $departure;
            $resultMinSize = $minPrint - $this->departure;
        }

        $check = $sizeBigger <= $this->resultBiggerSize && $sizeMin <= $resultMinSize;

        return $this->checkMinWithoutDuplex() && $check;
    }

    /**
     * Проверка наименьших значений без учёта дуплекса
     * @return bool
     */
    private function checkMinWithoutDuplex(): bool
    {
        $width = $this->isDuplexSize ? $this->width / 2 : $this->width;

        $sizeMin = min($width, $this->height);

        return $sizeMin >= $this->minRestrictionSize;
    }

    /**
     * Возвращает максимально возможное значение для печати
     * @param int|null $size
     * @param bool $useExtraMaxSize
     * @return int
     */
    private function getMax(int $size = null, bool $useExtraMaxSize = false): int
    {
        if ($useExtraMaxSize) {
            $extraMaxSize = $this->restriction?->extra_max_size;
        }

        if (isset($extraMaxSize)) {
            $size = $extraMaxSize;
            $this->maxRestrictionSize = $extraMaxSize;
        }

        return $size;
    }

    /**
     * Вызывает ошибку печати
     * @return void
     * @throws PrintSizeException
     */
    public function throwException(): void
    {
        $width = $this->print->width ?: $this->maxRestrictionSize;
        $height = $this->print->height ?: $this->maxRestrictionSize;

        throw new PrintSizeException(
            message: $this->message(
                isPrintRestrict: (bool) min($this->print->width, $this->print->height),
                defaultWidth: $width,
                defaultHeight: $height,
            ),
            parameters: [
                'max_width' => $width,
                'max_height' => $height,
                'min_size' => $this->minRestrictionSize,
                'max_size' => max($this->maxRestrictionSize, $width, $height) - $this->departure,
                'fields' => $this->restriction?->message?->error_fields ?? ['width_height', 'diameter'],
            ],
        );
    }

    /**
     * Возвращает пользовательское сообщение об ошибке допустимых значений
     * Изменяет все значения записанные как #{prefix}_field#, на значения полей из базы
     *
     * {prefix}_field - название поля в базе
     * {prefix} - для разделения полей между таблицами, print && restriction
     *
     * @param bool $isPrintRestrict
     * @param int|null $defaultWidth
     * @param int|null $defaultHeight
     * @return string
     */
    private function message(bool $isPrintRestrict, int $defaultWidth = null, int $defaultHeight = null): string
    {
        $printMax = max($this->print->width, $this->print->height) - $this->departure;
        $printMin = min($this->print->width, $this->print->height) - $this->departure;

        $duplexDel = 1;

        if ($this->isDuplexSize) {
            $duplexDel *= 2;
        }

        $this->calcPrintSizes($printMax, $printMin, $duplexDel);

        $allProperties = Arr::collapse([
            $this->setPrefixArrayKeys('restriction', $this->restriction?->toArray()),
            $this->setPrefixArrayKeys('print', $this->print?->toArray()),
            [
                'print_max' => $printMax / $duplexDel,
                'absolute_print_max' => $printMax,
                'print_min' => $printMin,
                'max_size' => $this->resultBiggerSize,
                'min_size' => $this->minRestrictionSize,
            ],
        ]);

        $message = $this->restriction?->messages();

        if ($this->useExtraMaxSize) {
            $message?->where('is_extra', $this->useExtraMaxSize);
        } else {
            $message?->where('is_print_restrict', $isPrintRestrict);
        }

        $message = $message?->first()?->text;

        if ($message) {
            foreach ($allProperties as $field => $value) {
                if (!is_iterable($value)) {
                    $message = Str::replace("#{$field}#", $value, $message);
                }
            }
        }

        return $message ?? $this->getDefaultMessage($defaultWidth, $defaultHeight);
    }

    /**
     * Дефолтное сообщение для пользователя
     * @param int $width
     * @param int $height
     * @return string
     */
    private function getDefaultMessage(int $width, int $height): string
    {
        return sprintf(
            'Минимальный размер печати от %sx%s до %sx%s',
            $this->minRestrictionSize,
            $this->minRestrictionSize,
            $width,
            $height,
        );
    }

    /**
     * Проставляет префиксы для ключей массива
     * @param string $prefix
     * @param array|null $array
     * @return array
     */
    private function setPrefixArrayKeys(string $prefix, array $array = null): array
    {
        if (!$array) {
            return [];
        }

        foreach ($array as $key => $value) {
            $array["{$prefix}_{$key}"] = $value;
            unset($array[$key]);
        }

        return $array;
    }

    /**
     * Падсчитывает как именно должны отображаться значения в сообщении для пользователя
     * @param int $printMax
     * @param int $printMin
     * @param int $duplexDel деление ширины, если в подсчёте она увеличивается
     * @return void
     */
    protected function calcPrintSizes(int &$printMax, int &$printMin, int $duplexDel): void
    {
        if (!$this->width || $this->height) {
            return;
        }

        // условия меняют значения местами в зависимости от того, какое значение больше
        if (
            $this->width / $duplexDel > $this->height &&
            $printMin > 0 &&
            $this->width >= $this->minRestrictionSize &&
            $this->height >= $this->minRestrictionSize
        ) {
            $this->swapValues($printMin, $printMax);
        }

        // если разница в значениях слишком большая, меняет сообщение в большую сторону
        if (
            $this->height >= $this->width &&
            $this->width / $duplexDel / $this->height <= 1 &&
            $printMin > 0 &&
            !$this->isNotPrintRotation
        ) {
            $this->swapValues($printMin, $printMax);
        } else {
            if (
                $this->width / $duplexDel >= $this->height &&
                $this->height / ($this->width / $duplexDel) <= 1 &&
                $printMin > 0 &&
                !$this->isNotPrintRotation
            ) {
                $this->swapValues($printMin, $printMax);
            }
        }

        // меняет значения местами, для калькуляторов где нет ограничения по размерам
        if ($this->width / $duplexDel > $this->height && $printMin <= 0 && !$this->useExtraMaxSize) {
            $this->swapValues($this->resultBiggerSize, $printMax);
        }
    }

    /**
     * Меняет значения переменных между собой
     * @param mixed $value1
     * @param mixed $value2
     * @return void
     */
    private function swapValues(mixed &$value1, mixed &$value2): void
    {
        [$value1, $value2] = [$value2, $value1];
    }
}
