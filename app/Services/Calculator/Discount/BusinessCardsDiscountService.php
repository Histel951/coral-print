<?php

namespace App\Services\Calculator\Discount;

use App\Models\Calculator;
use App\Services\Calculator\Count\Algorithms\Calculator as CalculatedCalculator;

class BusinessCardsDiscountService extends CalculatorDiscountService
{
    /**
     * @param Calculator $calculator
     */
    public function __construct(private readonly Calculator $calculator)
    {
    }

    /**
     * Значение которому должно быть кратно количество продукции
     * @var int
     */
    private const PRODUCT_COUNT_ALIQUOT = 50;

    /**
     * @param CalculatedCalculator|array $calculator
     * @param int $productCount
     * @param object|array $parameters
     * @param float $minPrice
     * @return array
     */
    public function get(
        CalculatedCalculator|array $calculator,
        int $productCount,
        object|array $parameters = [],
        float $minPrice = 0,
    ): array {
        $parentResult = parent::get($calculator, $productCount, $parameters, $minPrice);

        if (!$parentResult['min_product_count']) {
            return $parentResult;
        }

        // подсчёт минимального количества продукции для визиток
        // которое будет кратно 50
        $aliquot = ceil($parentResult['min_product_count'] / self::PRODUCT_COUNT_ALIQUOT);
        $newMinProductCount = $aliquot * self::PRODUCT_COUNT_ALIQUOT;

        $calculable = $this->getCalculable($calculator, $newMinProductCount, $parameters);
        $totalPrice = $calculable['total_price'];
        if (floor($totalPrice) <= $minPrice) {
            $newMinProductCount += self::PRODUCT_COUNT_ALIQUOT;
        }
        $parentResult['min_product_count'] = $newMinProductCount;

        return $parentResult;
    }

    /**
     * Возвращает шаг в зависимости от количества продуктов
     * @param int $productCount
     * @return int
     */
    protected function getDiscountStep(int &$productCount): int
    {
        if ($productCount < 100) {
            $productCount = ceil($productCount / 50) * 50;
            $step = 50;
        } elseif ($productCount < 1000) {
            $productCount = ceil($productCount / 100) * 100;
            $step = 100;
        } elseif ($productCount < 10000) {
            $productCount = intval($productCount / 500) * 500 + 2000;
            $step = 500;
        } else {
            $productCount = ceil($productCount / 1000) * 1000;
            $step = 1500;
        }

        return $step;
    }

    /**
     * Сет параметров под визитки + подсчёт
     * @param CalculatedCalculator|array $calculator
     * @param int $productCount
     * @param object|array $parameters
     * @return array
     */
    protected function getCalculable(
        CalculatedCalculator|array $calculator,
        int $productCount,
        object|array $parameters,
    ): array {
        $calculator = clone $calculator;
        $calculator->setProductCount($productCount)->setProductQuantity($productCount);
        $calculator->getBeforeTotal($parameters, $this->calculator);
        $calculator->getTotalPrice();

        return $calculator->getCalculable();
    }
}
