<?php

declare(strict_types=1);

namespace App\Services\Calculator\Count;

use App\Models\Calculator;
use App\Models\Departure;
use App\Models\PrintForm;
use App\Services\Calculator\Count\Algorithms\Calculator as CalculatedCalculator;
use App\Services\Calculator\Count\Algorithms\CalculatorStickers;
use App\Services\Calculator\Count\Util\Exceptions\PrintSizeException;
use App\Services\Calculator\Discount\CalculatorDiscountInterface;
use App\Services\Calculator\WorkAdditionalService;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * Подсчёт стоимости калькуляторов типа "Наклейки"
 * @package CalculatorStickersCount
 */
class StickersCountService implements CalculatorCount
{
    use CountLeading;

    /**
     * Модель переданного калькулятора
     * @var Calculator
     */
    private readonly Calculator $calculator;

    /**
     * Подсчёт скидок
     * @var CalculatorDiscountInterface
     */
    private readonly CalculatorDiscountInterface $calculatorDiscount;

    /**
     * @param Calculator $calculator
     * @throws BindingResolutionException
     */
    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
        $this->calculatorDiscount = app()->make(CalculatorDiscountInterface::class);
    }

    /**
     * Подсчитывает стоимость печати для калькулятора с выбранными параметрами
     * @param array $parameters
     * @return array
     * @throws Exception
     */
    public function get(array $parameters = []): array
    {
        $parameters = (object) $parameters;
        $this->getSizes($parameters, isset($parameters->form) ? PrintForm::find($parameters->form) : null);
        $parameters->printId = $this->getPrintId($parameters);
        $calculatedCalculator = new CalculatorStickers($this->calculator);
        $parameters->departure = $this->getDeparture($parameters);
        $calculatedCalculator->setDeparture($parameters->departure ?? 2); // по умолчанию наценка 2
        $calculatedCalculator->setLayoutSize($parameters->width, $parameters->height);

        try {
            $this->setPrint($calculatedCalculator, $parameters);
        } catch (PrintSizeException $exception) {
            return $this->printErrorResponse($exception, $parameters);
        }

        if (isset($parameters->material)) {
            $calculatedCalculator->setMaterial((int) $parameters->material);
        }

        if (isset($parameters->cutting)) {
            $calculatedCalculator->setCutting($parameters->cutting)->setType((string) $this->calculator->id);
        }

        $calculatedCalculator->setPrintWidthWithoutPrint((int) $this->calculator->width_without_print);
        $this->setAdditionalWorks($calculatedCalculator, $parameters);

        return $this->getResultResponse($parameters, $calculatedCalculator);
    }

    /**
     * Устанавливает тип печати для подсчётного калькулятора
     * @param CalculatedCalculator $calculatedCalculator
     * @param object $parameters
     * @return void
     * @throws PrintSizeException
     */
    private function setPrint(CalculatedCalculator &$calculatedCalculator, object $parameters): void
    {
        $cacheKey = cache_key('calculator:stickers:specie_type_id:', [
            'print_id' => $parameters->print_type ?? null,
            'is_white_print' => $parameters->white_print ?? null,
            'calculator_id' => $this->calculator->id,
        ]);

        $cache = Cache::tags(['calculator', 'specie_type']);

        $useExtraSize = fn () => $this->calculator->parameters['is_volume_calculator_print'] ?? false or
            ((int) isset($parameters->volume) ? (int) $parameters->volume : 0);

        if ($cache->has($cacheKey)) {
            $calculatedCalculator->setPrint(
                (int) $cache->get($cacheKey),
                checkSizes: true,
                useExtraMaxSize: $useExtraSize(),
            );
            return;
        }

        $specieType = $this->calculator->specieTypes();

        if (isset($parameters->print_type)) {
            $specieType->wherePivot('print_id', $parameters->print_type);
        }

        if (isset($parameters->white_print) and (int) $parameters->white_print) {
            $specieType->wherePivot('is_white_print', true);
        } else {
            $specieType->wherePivot('is_white_print', null);
        }

        $specieType = $specieType->first();

        if ($specieType) {
            $cache->put($cacheKey, $specieType->id);
            $calculatedCalculator->setPrint($specieType->id, checkSizes: true, useExtraMaxSize: $useExtraSize());
        }
    }

    /**
     * Формирует массив - результат подсчёта
     * @param object $parameters
     * @param CalculatedCalculator $calculatedCalculator
     * @return array
     * @throws BindingResolutionException
     */
    private function getResultResponse(object $parameters, CalculatedCalculator $calculatedCalculator): array
    {
        if (isset($parameters->discount)) {
            return $this->discountResponse($calculatedCalculator, $parameters);
        }

        $calculatedCalculator->setProductCount((int) $parameters->product_count);
        $calculatedCalculator->getBeforeTotal();
        $calculatedCalculator->getTotalPrice();
        $calc = $calculatedCalculator->getCalculable();

        if (Auth::check()) {
            $allCalcData = (string) view('calc.debug.debug_template', ['calculable' => $calc]);
            return [
                'all_calc_data' => $allCalcData,
                'weight' => $calc['weight'],
                ...$this->getPriceWithMinPrice(
                    productCount: (int) $parameters->product_count,
                    totalPrice: (float) $calc['total_price'],
                    itemPrice: (float) $calc['count_item_price'],
                ),
            ];
        }

        return $calculatedCalculator->getTotalOnly();
    }

    /**
     * Подсчитывает общую цену печати и цену за 1 штуку если цена печати меньше минимальной цены
     * @param int $productCount
     * @param float $totalPrice
     * @param float $itemPrice
     * @return array
     */
    private function getPriceWithMinPrice(int $productCount, float $totalPrice, float $itemPrice): array
    {
        if ($totalPrice < $this->calculator->min_price) {
            $totalPrice = $this->calculator->min_price;

            $itemPrice = $totalPrice / $productCount;
        }

        return [
            'total_price' => $totalPrice,
            'item_price' => $itemPrice,
        ];
    }

    /**
     * Получает print_id
     * @param object $parameters
     * @return int
     */
    private function getPrintId(object $parameters): int
    {
        if (isset($parameters->print_type)) {
            return (int) $parameters->print_type;
        }

        $cacheKey = cache_key('calculator:stickers:print_id', [
            'calculator_id' => $this->calculator->id,
        ]);

        return (int) Cache::tags(['calculator', 'prints'])->remember(
            $cacheKey,
            now()->addHours(6),
            fn () => $this->calculator->prints()?->first()->id,
        );
    }

    /**
     * Получение отправки
     * @param object $parameters
     * @return int
     */
    private function getDeparture(object $parameters): int
    {
        $cacheKey = cache_key('calculator:stickers:departure', [
            'calculator_id' => $this->calculator->id,
            'cutting' => $parameters->cutting ?? null,
        ]);

        $cache = Cache::tags(['calculator', 'departure']);

        if ($cache->has($cacheKey)) {
            return (int) $cache->get($cacheKey);
        }

        $departure = 2;
        if (isset($parameters->cutting)) {
            $departure = Departure::where('cutting_id', $parameters->cutting)?->first()?->value ?? 2;
        }

        $cache->put($cacheKey, $departure, now()->addDays(2));
        return $departure;
    }

    /**
     * Устанавливает доп работы для подсчётного калькулятора в зависимости от переданных параметров
     * @param CalculatedCalculator $calculatedCalculator
     * @param object $parameters
     * @return void
     */
    private function setAdditionalWorks(CalculatedCalculator &$calculatedCalculator, object $parameters): void
    {
        if (isset($parameters->quantity_types)) {
            $quantity_types = explode(',', $parameters->quantity_types);
            if (count($quantity_types) > 1) {
                WorkAdditionalService::setCalculatorWorks(
                    $calculatedCalculator,
                    [
                        'is_quantity_types' => 1,
                    ],
                    count($quantity_types) - 1,
                );
            }
        }

        // доп работы только по ID калькулятора - работает норм
        WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
            'calculator_id' => $this->calculator->id,
        ]);

        // доп работы только для конкретного ID print_type
        WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
            'print_type_id' => (int) $parameters->printId,
        ]);

        // доп работы только для конкретного ID print_type && calculator_id
        WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
            'calculator_id' => $this->calculator->id,
            'print_type_id' => (int) $parameters->printId,
        ]);

        // доп работы только по lamination_id
        if (isset($parameters->lam)) {
            WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                'lamination_id' => (int) $parameters->lam,
            ]);
        }

        if (isset($parameters->cutting)) {
            WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                'print_type_id' => (int) $parameters->printId,
                'cutting_id' => (int) $parameters->cutting,
            ]);
        }

        if (isset($parameters->foiling)) {
            WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                'foiling_id' => (int) $parameters->foiling,
            ]);

            WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                'foiling_id' => (int) $parameters->foiling,
                'calculator_id' => (int) $this->calculator->id,
            ]);
        }

        if (isset($parameters->complex_form) or isset($parameters->form)) {
            if (isset($parameters->form)) {
                $form = true;

                WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                    'print_form_id' => (int) $parameters->form,
                ]);
            }

            if (isset($parameters->complex_form) and (int) $parameters->complex_form) {
                $form = true;

                WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                    'is_complex_form' => $parameters->complex_form,
                ]);
            }

            if (isset($parameters->volume) and (int) $parameters->volume) {
                WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                    'is_volume' => $parameters->volume,
                    $form ?? false ? 'print_form_id' : 'is_complex_form' => ':notNull:',
                ]);
            }
        }

        if (isset($parameters->volume) and (int) $parameters->volume) {
            WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                'is_volume' => $parameters->volume,
            ]);
        }

        if (isset($parameters->volume) and (int) $parameters->volume and isset($parameters->form)) {
            WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                'is_volume' => $parameters->volume,
                'print_form_id' => $parameters->form,
                'calculator_id' => $this->calculator->id,
            ]);
        }

        if (isset($parameters->mounting_film) and (int) $parameters->mounting_film) {
            WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                'is_mounting_film' => $parameters->mounting_film,
            ]);

            if (isset($parameters->small_objects) and (int) $parameters->small_objects) {
                WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                    'is_mounting_film' => $parameters->mounting_film,
                    'is_small_objects' => $parameters->small_objects,
                ]);
            }
        }
    }
}
