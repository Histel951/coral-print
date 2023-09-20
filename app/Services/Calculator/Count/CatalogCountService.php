<?php

declare(strict_types=1);

namespace App\Services\Calculator\Count;

use App\Models\Calculator;
use App\Models\CalculatorSub;
use App\Models\Color;
use App\Models\SpecieType;
use App\Services\Calculator\Count\Algorithms\Calculator as CalculatedCalculator;
use App\Services\Calculator\Count\Algorithms\CalculatorCatalogs;
use App\Services\Calculator\Count\Util\Exceptions\PrintSizeException;
use App\Services\Calculator\Discount\CalculatorDiscountInterface;
use App\Services\Calculator\WorkAdditionalService;
use Exception;
use Illuminate\Support\Facades\Auth;

class CatalogCountService implements CalculatorCount
{
    use CountLeading;

    /**
     * Подкалькулятор покрытие
     * @var CalculatorSub
     */
    private readonly CalculatorSub $calculatorSubCover;

    /**
     * Подкалькулятор подложка
     * @var CalculatorSub
     */
    private readonly CalculatorSub $calculatorSubSubstrate;

    /**
     * Подкалькулятор блок
     * @var CalculatorSub
     */
    private readonly CalculatorSub $calculatorSubBlock;

    /**
     * Проверка на увеличенную ширина печати
     * @var bool
     */
    private bool $isDuplexWidth = false;

    /**
     * @var CalculatorDiscountInterface
     */
    private CalculatorDiscountInterface $discountService;

    /**
     * Количество страниц для блока
     * @var int
     */
    private int $pageCount;

    /**
     * Нужна для конечного подсчёта, увеличивает значение х2 on_page_count если значение таба дублируется
     * @var bool[]
     */
    private array $duplexes;

    public function __construct(private readonly Calculator $calculator)
    {
        $this->calculatorSubCover = $calculator
            ->calculatorSubs()
            ->where('name', 'cover')
            ->first();
        $this->calculatorSubBlock = $calculator
            ->calculatorSubs()
            ->where('name', 'block')
            ->first();

        if (
            $calculatorSubSubstrate = $this->calculator
                ->calculatorSubs()
                ->where('name', 'substrate')
                ->where('calculator_id', $calculator->id)
                ?->first()
        ) {
            $this->calculatorSubSubstrate = $calculatorSubSubstrate;
        }

        $this->discountService = app()->make(CalculatorDiscountInterface::class);
    }

    /**
     * Подсчитывает стоимость печати для калькулятора с выбранными параметрами
     * @param array $parameters
     * @return array
     * @throws CalculatorCountException|Exception
     */
    public function get(array $parameters = []): array
    {
        $parameters = (object) $parameters;
        $parameters->calculator_id = $this->calculator->id;

        $this->getSizes($parameters);
        $coefficient = $this->coefficient($parameters);

        try {
            if (
                isset($this->calculator->parameters['is_not_wide_block']) and
                $this->calculator->parameters['is_not_wide_block']
            ) {
                $block = $this->setBlock($parameters);
            }

            $parameters->width = $this->wideWidth($parameters->width);
            $cover = $this->setCover($parameters, $coefficient);

            if (!isset($block)) {
                $block = $this->setBlock($parameters);
            }

            if (isset($this->calculatorSubSubstrate)) {
                $substrate = $this->setSubstrate($parameters);
            }
        } catch (PrintSizeException $exception) {
            return $this->printErrorResponse($exception, $parameters);
        }

        if (isset($parameters->discount)) {
            $allCalculators = ['cover' => $cover, 'block' => $block];

            if (isset($substrate)) {
                $allCalculators['substrate'] = $substrate;
            }

            return $this->discountResponse($allCalculators, $parameters);
        }

        return $this->getResultCount(
            parameters: $parameters,
            calculableCover: $this->calculable($cover, $parameters),
            calculableBlock: $this->calculable($block, $parameters),
            calculableSubstrate: isset($substrate) ? $this->calculable($substrate, $parameters) : null,
        );
    }

    /**
     * Возвращает результат подсчёта
     * @param object $parameters
     * @param array $calculableCover
     * @param array $calculableBlock
     * @param array|null $calculableSubstrate
     * @return array
     */
    private function getResultCount(
        object $parameters,
        array $calculableCover,
        array $calculableBlock,
        array $calculableSubstrate = null,
    ): array {
        $totalCost = $calculableCover['total_cost'] + $calculableBlock['total_cost'];
        $totalPrice = $calculableCover['total_price'] + $calculableBlock['total_price'];

        if (isset($calculableSubstrate)) {
            $totalCost += $calculableSubstrate['total_cost'];
            $totalPrice += $calculableSubstrate['total_price'];
        }

        $itemPrice = $totalPrice / (int) $parameters->product_count;
        $countItemPrice = ceil(round($itemPrice * 100, 2)) / 100;
        $finalTotalPrice = (int) $parameters->product_count * $itemPrice;

        $weightVolume = $this->calcWeightVolume([$calculableCover, $calculableBlock, $calculableSubstrate]);

        if (Auth::check()) {
            return $this->debugResponse(
                totalCost: $totalCost,
                finalTotalPrice: $finalTotalPrice,
                itemPrice: $itemPrice,
                countItemPrice: $countItemPrice,
                calculableCover: $calculableCover,
                calculableBlock: $calculableBlock,
                weightVolume: $weightVolume,
                calculableSubstrate: $calculableSubstrate,
            );
        }

        return $this->resultResponse($finalTotalPrice, $countItemPrice, $weightVolume);
    }

    /**
     * Возвращает результат подсчёта
     * @param float $finalTotalPrice
     * @param float $countItemPrice
     * @return array
     */
    private function resultResponse(float $finalTotalPrice, float $countItemPrice, array $weightVolume): array
    {
        return [
            'is_check_restriction' => true,
            'total_price' => $finalTotalPrice,
            'item_price' => $countItemPrice,
            'weight' => $weightVolume['weight'] ?? null,
            'volume' => $weightVolume['volume'] ?? null,
        ];
    }

    /**
     * Возвращает ответ с данными для дебага
     * @param float $totalCost
     * @param float $finalTotalPrice
     * @param float $itemPrice
     * @param float $countItemPrice
     * @param array $calculableCover
     * @param array $calculableBlock
     * @param array|null $calculableSubstrate
     * @return array
     */
    private function debugResponse(
        float $totalCost,
        float $finalTotalPrice,
        float $itemPrice,
        float $countItemPrice,
        array $calculableCover,
        array $calculableBlock,
        array $weightVolume,
        array $calculableSubstrate = null,
    ): array {
        $total = [
            'total_cost' => $totalCost,
            'total_price' => $finalTotalPrice,
            'item_price' => $itemPrice,
            'count_item_price' => $countItemPrice,
        ];

        $allCalcData = (string) view('calc.debug.debug_catalog', [
            'calculable' => [
                'cover' => $calculableCover,
                'block' => $calculableBlock,
                'substrate' => $calculableSubstrate ?? false,
                'total' => $total,
            ],
            ...$weightVolume,
        ]);

        return [
            'is_check_restriction' => true,
            'all_calc_data' => $allCalcData,
            'total_price' => $finalTotalPrice,
            'item_price' => $countItemPrice,
            'weight' => $weightVolume['weight'] ?? null,
            'volume' => $weightVolume['volume'] ?? null,
        ];
    }

    /**
     * Подсчёт общей ширины и объёма для дебага
     * @param array $calculables
     * @return array
     */
    private function calcWeightVolume(array $calculables): array
    {
        $result = [];

        $keys = ['weight', 'volume'];
        foreach ($keys as $key) {
            foreach ($calculables as $calculable) {
                if ($calculable and isset($calculable[$key])) {
                    if (!isset($result[$key])) {
                        $result[$key] = 0;
                    }

                    $result[$key] += $calculable[$key];
                }
            }
        }

        return $result;
    }

    /**
     * Устанавливает значения для substrate калькулятора
     * @param object $parameters
     * @return CalculatedCalculator
     * @throws Exception
     */
    private function setSubstrate(object $parameters): CalculatedCalculator
    {
        $substrate = new CalculatorCatalogs($this->calculator);
        $substrate->setDeparture();
        $substrate->setPart('substrate');
        $substrate->setLayoutSize((int) $parameters->width, (int) $parameters->height);

        if (isset($parameters->color_substrate_select)) {
            $this->setAdditionalWorksColor($substrate, (int) $parameters->color_substrate_select);

            $this->setPrint(
                calculatedCalculator: $substrate,
                calculatorSub: $this->calculatorSubSubstrate,
                color: (int) $parameters->color_substrate_select,
            );
        }

        // todo: придумать как запихнуть в базу и подтянуть
        if (isset($parameters->plastic_substrate_select) and (int) $parameters->plastic_substrate_select > 1) {
            if ((int) $parameters->material_substrate_select !== 99) {
                $substrate->setMaterial($parameters->material_substrate_select, 'paper');
                $substrate->setMaterial(99, 'plastic');
            } else {
                $substrate->setMaterial(99);
            }
        } else {
            $substrate->setMaterial($parameters->material_substrate_select);
        }

        $substrate->setProductCount((int) $parameters->product_count);

        $this->setAdditionalWorksSubstrate($substrate, $parameters);

        return $substrate;
    }

    /**
     * Устанавливает значения для block калькулятора
     * @param object $parameters
     * @return CalculatedCalculator
     * @throws Exception
     */
    private function setBlock(object $parameters): CalculatedCalculator
    {
        $block = new CalculatorCatalogs($this->calculator);
        $block->setDeparture();
        $block->setType((string) $this->calculator->id);
        $block->setPart('block');
        $block->setProductQuantity((int) $parameters->product_count);
        $block->setLayoutSize((int) $parameters->width, (int) $parameters->height);

        if (isset($parameters->color_block_select)) {
            $this->setPrint(
                calculatedCalculator: $block,
                calculatorSub: $this->calculatorSubBlock,
                color: (int) $parameters->color_block_select,
            );
        }

        $block->setMaterial($parameters->material_block_select);

        if (isset($this->calculator->parameters['is_low_pages'])) {
            $pageCount = (((int) $parameters->page_count) - 4) / 4;
        } else {
            $pageCount = $parameters->page_count;
        }

        if (isset($this->calculator->parameters['is_notepads']) and $this->calculator->parameters['is_notepads']) {
            $pageCount *= 2;
        }

        $this->setAdditionalWorksBlock($block);

        $this->pageCount = (int) $pageCount;

        $block->setProductCount((int) $parameters->product_count * $pageCount);

        return $block;
    }

    /**
     * Устанавливает значения для cover калькулятора
     * @param object $parameters
     * @param float $coefficient - для доп работ
     * @return CalculatedCalculator
     * @throws Exception
     */
    private function setCover(object $parameters, float $coefficient = 1): CalculatedCalculator
    {
        $cover = new CalculatorCatalogs($this->calculator);
        $cover->setDeparture();
        $cover->setWidthHeight($parameters->width, $parameters->height);

        if (isset($parameters->plastic_cover_select) and (int) $parameters->plastic_cover_select) {
            $cover->setMaterial(99, 'plastic'); // todo: придумать как запихнуть в базу и подтянуть
            $cover->setMaterial($parameters->material_cover_select, 'paper');
        } else {
            $cover->setMaterial($parameters->material_cover_select);
        }

        $cover->setType((string) $this->calculator->id);
        $cover->setPart('cover');
        $cover->setLayoutSize((int) $parameters->width, (int) $parameters->height);

        if (isset($parameters->color_cover_select)) {
            $this->setPrint(
                calculatedCalculator: $cover,
                calculatorSub: $this->calculatorSubCover,
                color: (int) $parameters->color_cover_select,
                checkSizes: true,
                isDuplexPrint: $this->isDuplexWidth,
            );
        }

        $cover->setProductCount((int) $parameters->product_count);

        $this->setAdditionalWorksCover($cover, $parameters, $coefficient);

        return $cover;
    }

    /**
     * Общий метод подсчёта для калькуляторов
     * @param CalculatedCalculator $calculator
     * @param object $parameters
     * @return array
     */
    private function calculable(CalculatedCalculator $calculator, object $parameters): array
    {
        $calculator->getBeforeTotal($parameters);
        $calculator->getTotalPrice();

        return $calculator->getCalculable();
    }

    /**
     * Подсчитывает коэффициент для расчёта
     * @param object $parameters
     * @return float
     * @throws CalculatorCountException
     */
    private function coefficient(object $parameters): float
    {
        $coefficient = 1;

        if (isset($this->calculator->parameters['is_adhesive']) and $this->calculator->parameters['is_adhesive']) {
            $bigger = max($parameters->width, $parameters->height);

            if ($bigger + 4 <= 690) {
                $coefficient = 1.6;
            } else {
                throw new CalculatorCountException("Layout too big. Bigger is: \"{$bigger}\"");
            }
        }

        return $coefficient;
    }

    /**
     * Устанавливает принт если значение существует
     * @param CalculatedCalculator $calculatedCalculator
     * @param CalculatorSub $calculatorSub
     * @param int $color
     * @param bool $checkSizes
     * @param bool $isDuplexPrint
     * @return void
     * @throws PrintSizeException
     */
    private function setPrint(
        CalculatedCalculator &$calculatedCalculator,
        CalculatorSub &$calculatorSub,
        int $color,
        bool $checkSizes = false,
        bool $isDuplexPrint = false,
    ): void {
        $specieType = $this->getSpecieType($calculatorSub, $color);

        $this->duplexes[$calculatorSub->name] = $specieType?->pivot['is_duplex'];

        if (isset($specieType->id)) {
            $calculatedCalculator->setPrint(
                $specieType->id,
                (bool) $specieType->pivot['is_duplex'] ?? false,
                checkSizes: $checkSizes,
                isDuplexPrint: $isDuplexPrint,
            );
        }
    }

    /**
     * Получение печати
     * @param CalculatorSub $calculatorSub
     * @param int $color
     * @return SpecieType|null
     */
    private function getSpecieType(CalculatorSub $calculatorSub, int $color): SpecieType|null
    {
        $print = (int) $this->getPrintByColor($color)->id;

        $specieType = $calculatorSub->specieType()->wherePivot('calculator_id', $this->calculator->id);

        return $specieType
            ->withPivot('is_duplex')
            ->wherePivot('print_id', $print)
            ->first();
    }

    /**
     * Доп работы для cover
     * @param CalculatedCalculator $calculatedCalculator
     * @param object $parameters
     * @param float $coefficient
     * @return void
     */
    private function setAdditionalWorksCover(
        CalculatedCalculator &$calculatedCalculator,
        object $parameters,
        float $coefficient = 1,
    ): void {
        if (isset($parameters->bolt_cover_select)) {
            WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                'bolt_id' => $parameters->bolt_cover_select,
                'calculator_sub_id' => $this->calculatorSubCover->id,
            ]);
        }

        if (isset($parameters->lam_cover_select)) {
            WorkAdditionalService::setCalculatorWorks(
                $calculatedCalculator,
                [
                    'lamination_id' => $parameters->lam_cover_select,
                    'calculator_sub_id' => $this->calculatorSubCover->id,
                ],
                null,
                $coefficient,
            );
        }

        WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
            'calculator_id' => $this->calculator->id,
            'calculator_sub_id' => $this->calculatorSubCover->id,
        ]);

        if (isset($parameters->varnish_cover_select) and (int) $parameters->varnish_cover_select) {
            WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                'is_varnish' => (bool) (int) $parameters->varnish_cover_select,
                'calculator_sub_id' => $this->calculatorSubCover->id,
            ]);
        }

        if (isset($parameters->foiling_cover_select)) {
            WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                'foiling_id' => $parameters->foiling_cover_select,
                'calculator_sub_id' => $this->calculatorSubCover->id,
            ]);
        }
    }

    /**
     * Доп работы для block
     * @param CalculatedCalculator $calculatedCalculator
     * @return void
     */
    private function setAdditionalWorksBlock(CalculatedCalculator &$calculatedCalculator): void
    {
        WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
            'calculator_id' => $this->calculator->id,
            'calculator_sub_id' => $this->calculatorSubBlock->id,
        ]);
    }

    /**
     * Доп работы для подложки
     * @param CalculatedCalculator $calculatedCalculator
     * @param object $parameters
     * @return void
     */
    private function setAdditionalWorksSubstrate(CalculatedCalculator &$calculatedCalculator, object $parameters): void
    {
        if (isset($parameters->print_type_substrate_select)) {
            WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                'calculator_sub_id' => $this->calculatorSubSubstrate->id,
                'print_type_id' => $parameters->print_type_substrate_select,
            ]);
        }

        if (isset($parameters->lam_substrate_select)) {
            WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                'calculator_sub_id' => $this->calculatorSubSubstrate->id,
                'lamination_id' => $parameters->lam_substrate_select,
            ]);
        }

        WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
            'calculator_id' => $this->calculator->id,
            'calculator_sub_id' => $this->calculatorSubSubstrate->id,
        ]);
    }

    /**
     * @param int $width
     * @param string $calculatorParameter
     * @return int
     */
    private function wideWidth(int $width, string $calculatorParameter = 'is_wide'): int
    {
        if (
            isset($this->calculator->parameters[$calculatorParameter]) and
            $this->calculator->parameters[$calculatorParameter]
        ) {
            $this->isDuplexWidth = true;
            return $width * 2;
        }
        $this->isDuplexWidth = false;
        return $width;
    }

    private function setAdditionalWorksColor(CalculatedCalculator $calculator, int $colorId)
    {
        WorkAdditionalService::setCalculatorWorks($calculator, [
            'color_id' => $colorId,
        ]);
    }

    private function getPrintByColor(int $colorId): object
    {
        return Color::find($colorId)
            ->printModel()
            ->first();
    }
}
