<?php

namespace App\Services\Calculator\Count;

use App\Models\PrintForm;
use App\Services\Calculator\Count\Algorithms\Calculator;
use App\Services\Calculator\Count\Util\Exceptions\PrintSizeException;
use App\Services\Calculator\Discount\CalculatorDiscountInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Auth;

/**
 * Трейт чато используемых/общих методов для подсчёта
 * @package CountLeading
 */
trait CountLeading
{
    /**
     * Устанавливает нужные значения размеров для подсчёта в имеющийся объект параметров
     * @param object $parameters
     * @param PrintForm|null $printForm
     * @return void
     */
    private function getSizes(object &$parameters, PrintForm $printForm = null): void
    {
        if (isset($printForm->is_diameter) and $printForm->is_diameter) {
            $parameters->width = isset($parameters->diameter) ? (int) $parameters->diameter : (int) $parameters->width;
            $parameters->height = isset($parameters->diameter)
                ? (int) $parameters->diameter
                : (int) $parameters->height;
            return;
        }

        if (isset($parameters->is_diameter) && $parameters->is_diameter) {
            $parameters->width = ((int) $parameters->diameter) ?? 0;
            $parameters->height = ((int) $parameters->diameter) ?? 0;
            return;
        }

        if (isset($parameters->width)) {
            $parameters->width = ((int) $parameters?->width) ?? 0;
        }

        if (isset($parameters->height)) {
            $parameters->height = ((int) $parameters?->height) ?? 0;
        }

        if (isset($parameters->width) && isset($parameters->height)) {
            return;
        }

        if (isset($parameters->diameter)) {
            $parameters->width = (int) $parameters->diameter;
            $parameters->height = (int) $parameters->diameter;
            return;
        }

        $parameters->height = 0;
        $parameters->width = 0;
    }

    /**
     * Возвращает ошибку дебага, если переданные размеры не соответствуют печати
     * @param PrintSizeException $exception
     * @param object|array $parameters
     * @return array
     */
    private function printErrorResponse(PrintSizeException $exception, object|array $parameters): array
    {
        $parameters = (object) $parameters;

        $allCalcData = (string) view('calc.debug.debug_template', [
            'error' => $exception->getMessage(),
            'width' => $parameters->width,
            'height' => $parameters->height,
            ...$exception->getParameters(),
            'departure' => $parameters->departure ?? 2,
            'product_count' => $parameters->product_count,
        ]);

        return [
            'all_calc_data' => $allCalcData,
            'message' => $exception->getMessage(),
            'fields' => $exception->getParameters()['fields'],
            'is_check_restriction' => false,
            'restriction' => [...$exception->getParameters()],
            'total_price' => 0,
            'item_price' => 0,
        ];
    }

    /**
     * Подсчитывает скидку и возвращает результат
     * @param Calculator[] $calculatedCalculator
     * @param object $parameters
     * @return array
     * @throws BindingResolutionException
     */
    private function discountResponse(array|Calculator $calculatedCalculator, object $parameters): array
    {
        $calculatorDiscount = app()->make(CalculatorDiscountInterface::class, [
            'calculator' => $this->calculator,
        ]);

        $calc = $calculatorDiscount->get(
            calculator: $calculatedCalculator,
            productCount: (int) $parameters->product_count,
            parameters: $parameters,
            minPrice: $this->calculator->min_price,
        );

        return [
            'discounts' => $calc['discount_prices'],
            'discount_min_edition' => $calc['min_product_count'],
            'total_price' => $calc['total_price'],
            'item_price' => $calc['count_item_price'],
        ];
    }

    /**
     * Возвращает результат выполнения подсчёта
     * @param array $calculatedResult
     * @param string $debugTemplate
     * @return array
     */
    private function resultResponse(array $calculatedResult, string $debugTemplate = 'calc.debug.debug_template'): array
    {
        if (Auth::check()) {
            $allCalcData = (string) view($debugTemplate, ['calculable' => $calculatedResult]);

            return [
                'all_calc_data' => $allCalcData,
                'weight' => $calculatedResult['weight'],
                'total_price' => $calculatedResult['result_total_price'],
                'item_price' => $calculatedResult['count_item_price'],
            ];
        }

        return [
            'weight' => $calculatedResult['weight'],
            'total_price' => $calculatedResult['result_total_price'],
            'item_price' => $calculatedResult['count_item_price'],
        ];
    }
}
