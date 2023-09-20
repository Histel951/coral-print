<?php

namespace App\Services\Calculator\Count;

use App\Models\Calculator;
use App\Services\Calculator\Count\Algorithms\Calculator as CalculatedCalculator;
use App\Services\Calculator\Count\Algorithms\CalculatorTags;
use App\Services\Calculator\Count\Util\Exceptions\PrintSizeException;
use App\Services\Calculator\WorkAdditionalService;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 *
 */
class LabelsCountService implements CalculatorCount
{
    use CountLeading;

    /**
     * Цветность - двухсторонние цветные
     */

    private const TWO_COLORS_ID = 18;

    private const DEPARTURE_DEFAULT = 10;

    /**
     * Модель переданного калькулятора
     * @var Calculator
     */
    private Calculator $calculator;

    /**
     * @param Calculator $calculator
     */
    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * @inheritDoc
     * @throws BindingResolutionException
     */
    public function get(array $parameters = []): array
    {
        $parameters = (object) $parameters;
        $calculatedCalculator = new CalculatorTags($this->calculator);

        if (isset($parameters->material)) {
            $calculatedCalculator->setMaterial($parameters->material);
        } elseif ($this->calculator->materials->count()) {
            $calculatedCalculator->setMaterial($this->calculator->materials->first()?->id);
        }

        $this->getSizes($parameters);
        $this->setAdditionalWorks($calculatedCalculator, $parameters);
        $this->setDeparture($calculatedCalculator, $parameters);

        $calculatedCalculator
            ->setProductCount($parameters->product_count)
            ->setProductQuantity($parameters->product_count)
            ->setLayoutSize($parameters->width, $parameters->height);

        $calculatedCalculator->setType($parameters->type);
        $calculatedCalculator->setLayoutPrintCount();

        try {
            $this->setPrint($calculatedCalculator, $parameters);
        } catch (PrintSizeException $exception) {
            return $this->printErrorResponse($exception, $parameters);
        }

        if (isset($parameters->discount)) {
            return $this->discountResponse($calculatedCalculator, $parameters);
        }

        $calculatedCalculator->getBeforeTotal();
        $calculatedCalculator->getTotalPrice();

        $calc = $calculatedCalculator->getCalculable();

        return $this->resultResponse($calc);
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
        $specieType = $this->calculator->specieTypes();

        $specieType = $specieType->first();
        $duplex = isset($parameters->color) && $parameters->color == self::TWO_COLORS_ID;

        if ($specieType) {
            $calculatedCalculator->setPrint($specieType->id, $duplex, checkSizes: true, isDuplexPrint: false);
        }
    }

    /**
     * Устанавливает доп работы для подсчётного калькулятора в зависимости от переданных параметров
     * @param CalculatedCalculator $calculatedCalculator
     * @param object $parameters
     * @return void
     */
    private function setAdditionalWorks(CalculatedCalculator &$calculatedCalculator, object $parameters): void
    {
        WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
            'calculator_id' => $this->calculator->id,
        ]);

        if (isset($parameters->foiling_face)) {
            WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                'foiling_id' => $parameters->foiling_face,
                'calculator_id' => $this->calculator->id,
            ]);
        }

        $this->setBasicAdditionalWorks($calculatedCalculator, $parameters);
    }

    /**
     * @param CalculatedCalculator $calculatedCalculator
     * @param object $parameters
     * @return void
     */
    private function setBasicAdditionalWorks(CalculatedCalculator &$calculatedCalculator, object $parameters)
    {
        $addWorksConditions = [
            'lam' => [
                [
                    'calculator_id' => [$this->calculator->id],
                    'lamination_id' => [$parameters->lam],
                ],
            ],
            'foiling_face' => [
                [
                    'calculator_id' => [$this->calculator->id],
                    'foiling_face' => [
                        $this->calculator->calculatorType->foilingColorsWithoutNone
                            ->keyBy('id')
                            ->contains($parameters->foiling_face ?? null),
                    ],
                ],
            ],
            'foiling_back' => [
                [
                    'calculator_id' => [$this->calculator->id],
                    'foiling_face' => [
                        $this->calculator->calculatorType->foilingColorsWithoutNone
                            ->keyBy('id')
                            ->contains($parameters?->foiling_back ?? null),
                    ],
                ],
            ],
            'rounding_corners' => [
                [
                    'calculator_id' => [$this->calculator->id],
                    'is_rounding_corners' => [true],
                ],
            ],
            'folded' => [
                [
                    'calculator_id' => [$this->calculator->id],
                    'is_folded' => [true],
                ],
            ],
            'hole' => [
                [
                    'calculator_id' => [$this->calculator->id],
                    'hole_id' => [$parameters->hole ?? null],
                ],
            ],
        ];

        foreach ($addWorksConditions as $parName => $addWorksCondition) {
            if (isset($parameters->$parName) && $parameters->$parName) {
                foreach ($addWorksCondition as $addWorkCondition) {
                    WorkAdditionalService::setCalculatorWorks($calculatedCalculator, $addWorkCondition);
                }
            }
        }
    }

    /**
     * @param CalculatedCalculator $calculatedCalculator
     * @param object $parameters
     * @return void
     */
    private function setDeparture(CalculatedCalculator &$calculatedCalculator, object $parameters)
    {
        if ($this->calculator->departure) {
            $departure = $this->calculator->departure->value;
        } else {
            $departure = self::DEPARTURE_DEFAULT;
        }

        $calculatedCalculator->setDeparture($departure);
    }
}
