<?php

namespace App\Services\Calculator\Discount;

use App\Models\Calculator;
use App\Services\Calculator\Count\Algorithms\Calculator as CalculatedCalculator;

class CatalogDiscountService extends CalculatorDiscountService
{
    /**
     * @param Calculator $calculator
     */
    public function __construct(private readonly Calculator $calculator)
    {
    }

    /**
     * @param CalculatedCalculator[] $calculator
     * @param int $productCount
     * @param object|array $parameters
     * @return array
     */
    protected function getCalculable(
        CalculatedCalculator|array $calculator,
        int $productCount,
        object|array $parameters,
    ): array {
        $totalPrice = 0;
        foreach ($calculator as $blockName => $countCalculator) {
            $cloneCalculator = clone $countCalculator;

            if ($blockName === 'block') {
                $calculated = $this->calcBlockProductCount($cloneCalculator, $productCount, $parameters);
            } else {
                $calculated = $this->calcDefaultProductCount($cloneCalculator, $productCount, $parameters);
            }

            $totalPrice += $calculated['total_price'];
        }

        $itemPrice = $totalPrice / $productCount;
        $itemPrice = ceil(round($itemPrice * 100, 2)) / 100;
        $totalPrice = $productCount * ($totalPrice / $productCount);

        $calculated['total_price'] = $totalPrice;
        $calculated['count_item_price'] = $itemPrice;

        return $calculated;
    }

    /**
     * Подсчёт для обычных калькуляторов
     * @param CalculatedCalculator $calculator
     * @param int $productCount
     * @param object $parameters
     * @return array
     */
    private function calcDefaultProductCount(
        CalculatedCalculator $calculator,
        int $productCount,
        object $parameters,
    ): array {
        $calculator->setProductCount($productCount);
        $calculator->getBeforeTotal($parameters);
        $calculator->getTotalPrice();

        return $calculator->getCalculable();
    }

    /**
     * Устанавливает productCount для блока
     * @param CalculatedCalculator $calculator
     * @param int $productCount
     * @param object $parameters
     * @return array
     */
    private function calcBlockProductCount(
        CalculatedCalculator $calculator,
        int $productCount,
        object $parameters,
    ): array {
        $calculator->setProductCount($productCount);

        if (isset($this->calculator->parameters['is_low_pages']) && $this->calculator->parameters['is_low_pages']) {
            $pageCount = (((int) $parameters->page_count) - 4) / 4;
        } else {
            $pageCount = $parameters->page_count;
        }

        if (isset($this->calculator->parameters['is_notepads']) and $this->calculator->parameters['is_notepads']) {
            $pageCount *= 2;
        }

        $calculator->setProductQuantity($productCount * $pageCount);
        $calculator->getBeforeTotal($parameters);
        $calculator->getTotalPrice();

        return $calculator->getCalculable();
    }
}
