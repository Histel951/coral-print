<?php

namespace App\Services\Calculator\Discount;

use App\Services\Calculator\Count\Algorithms\Calculator;

class CalculatorDiscountService implements CalculatorDiscountInterface
{
    /**
     * Максимальное количество подсчитанных скидок
     * @var int
     */
    private const MAX_DISCOUNTS = 4;

    /**
     * Подсчитанные скидки
     * @var array
     */
    private array $discounts = [];

    /**
     * Возвращает подсчитанную скидку на цены
     * @param Calculator|array $calculator
     * @param int $productCount
     * @param object|array $parameters
     * @param float $minPrice
     * @return array
     */
    public function get(
        Calculator|array $calculator,
        int $productCount,
        object|array $parameters = [],
        float $minPrice = 0,
    ): array {
        $step = 1;
        $percentCurrent = -10;
        $minProductCount = 0;
        $calculable = $this->getCalculable($calculator, $productCount, $parameters);
        $isOneStepGap = true;
        $isMinPrice = null;
        $maxIterations = 10000;

        $dataTotalPrice = $calculable['total_price'];
        $dataItemPrice = $calculable['count_item_price'];

        for ($i = 1; $i <= $maxIterations && count($this->discounts) < self::MAX_DISCOUNTS; $i++) {
            $calculableCalc = $this->getCalculable($calculator, $productCount, $parameters);
            if ($minPrice >= floor($calculableCalc['total_price'])) {
                $isMinPrice = true;
                $productCount += $step;
                continue;
            }

            if ($isMinPrice) {
                $minProductCount = $productCount;
                break;
            }

            $percent = $this->getPercent($dataItemPrice, $calculableCalc['count_item_price']);
            if ($isOneStepGap) {
                $step = $this->getDiscountStep($productCount);
                $isOneStepGap = false;
            } else {
                if ($percent <= $percentCurrent && ($step === 1 || !($productCount % $step))) {
                    $maxIterations -= 500;

                    $this->addDiscount(
                        productCount: $productCount,
                        totalPrice: $calculable['total_price'],
                        itemPrice: $calculableCalc['count_item_price'],
                        percent: $percent,
                    );
                    $percentCurrent = $percent - 5;
                }
                $productCount += $step;
            }
        }

        return [
            'total_price' => $dataTotalPrice,
            'count_item_price' => $dataItemPrice,
            'discount_prices' => $this->discounts,
            'min_product_count' => $minProductCount,
        ];
    }

    /**
     * Добавляет подсчитанную скидку в массив
     * @param int $productCount
     * @param float $totalPrice
     * @param float $itemPrice
     * @param float $percent
     * @return void
     */
    protected function addDiscount(int $productCount, float $totalPrice, float $itemPrice, float $percent): void
    {
        $this->discounts[] = [
            'product_count' => $productCount,
            'total_price' => $totalPrice,
            'count_item_price' => round($itemPrice, 2),
            'percent' => ceil($percent),
        ];
    }

    /**
     * Возвращает подсчитанные данные калькулятора(-ов)
     * @param Calculator|array $calculator
     * @param int $productCount
     * @param object|array $parameters
     * @return array
     */
    protected function getCalculable(Calculator|array $calculator, int $productCount, object|array $parameters): array
    {
        if (is_array($calculator)) {
            $totalPrice = 0;

            foreach ($calculator as $calc) {
                $curCalculator = clone $calc;
                $curCalculator->setProductCount($productCount);
                $curCalculator->getBeforeTotal($parameters);
                $curCalculator->getTotalPrice();
                $calculable = $curCalculator->getCalculable();

                $totalPrice += $calculable['total_price'];
            }

            $itemPrice = $totalPrice / $productCount;
            $itemPrice = ceil(round($itemPrice * 100, 2)) / 100;
            $totalPrice = $productCount * ($totalPrice / $productCount);

            $calculable['total_price'] = $totalPrice;
            $calculable['count_item_price'] = $itemPrice;
        } else {
            $calculator = clone $calculator;
            $calculator->setProductCount($productCount);
            $calculator->getBeforeTotal($parameters);
            $calculator->getTotalPrice();
            $calculable = $calculator->getCalculable();
        }

        return $calculable;
    }

    /**
     * Возвращает шаг в зависимости от количества продуктов
     * @param int $productCount
     * @return int
     */
    protected function getDiscountStep(int &$productCount): int
    {
        if ($productCount >= 50 && $productCount < 100) {
            $productCount = ceil($productCount / 10) * 10;
            $step = 10;
        } elseif ($productCount < 1000) {
            $productCount = ceil($productCount / 100) * 100;
            $step = 100;
        } elseif ($productCount < 10000) {
            $productCount = intval($productCount / 500) * 500 + 500;
            $step = 500;
        } else {
            $productCount = ceil($productCount / 1000) * 1000;
            $step = 1000;
        }

        return $step;
    }

    /**
     * Подсчитывает процент скидки в зависимости от первоначальной цены за штуку и подсчитанной цены
     * @param float $dataItemPrice
     * @param float $countItemPrice
     * @return int
     */
    protected function getPercent(float $dataItemPrice, float $countItemPrice): int
    {
        return (($countItemPrice - $dataItemPrice) / $dataItemPrice) * 100;
    }
}
