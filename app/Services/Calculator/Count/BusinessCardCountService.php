<?php

namespace App\Services\Calculator\Count;

use App\Models\Calculator;
use App\Models\Color;
use App\Models\ColorCount;
use App\Models\Foiling;
use App\Models\PrintForm;
use App\Services\Calculator\Count\Algorithms\Calculator as CalculatedCalculator;
use App\Services\Calculator\Count\Algorithms\CalculatorBusinessCards;
use App\Services\Calculator\Count\Util\Exceptions\PrintSizeException;
use App\Services\Calculator\WorkAdditionalService;
use Illuminate\Contracts\Container\BindingResolutionException;

class BusinessCardCountService implements CalculatorCount
{
    use CountLeading;

    /**
     * Форма - прямоугольник
     * @var int
     */
    private const RECTANGLE_FORM_ID = 55;

    /**
     * Дефолтный вылет
     * @var int
     */
    private const DEPARTURE_DEFAULT = 2;

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
        $isBlockSelect = (bool) $this->calculator->calculatorSubs()->first();
        $calculatedCalculator = new CalculatorBusinessCards($this->calculator);

        if (isset($parameters->form)) {
            $calculatedCalculator->setCutting($parameters->form);
        }

        if (isset($parameters->material)) {
            $calculatedCalculator->setMaterial($parameters->material);
        } elseif ($this->calculator->materials->count()) {
            $calculatedCalculator->setMaterial($this->calculator->materials->first()?->id);
        }

        if (isset($parameters->color_count_face) && isset($parameters->color_count_back)) {
            $parameters->color_count_face = ColorCount::query()->find($parameters->color_count_face)->value;
            $parameters->color_count_back = ColorCount::query()->find($parameters->color_count_back)->value;
        }

        if (
            isset($parameters->color_count_face_visitki_vip_face_select) &&
            isset($parameters->color_count_back_visitki_vip_back_select)
        ) {
            $parameters->color_count_face = ColorCount::query()->find(
                $parameters->color_count_face_visitki_vip_face_select,
            )?->value;
            $parameters->color_count_back = ColorCount::query()->find(
                $parameters->color_count_back_visitki_vip_back_select,
            )?->value;
        }

        if (isset($parameters->color_count_face) || isset($parameters->color_count_back)) {
            $calculatedCalculator->setPaintsQuantity(
                paints_face: $parameters->color_count_face ?? 0,
                paints_back: $parameters->color_count_back ?? 0,
            );
        }

        $this->setBlockSelectData($calculatedCalculator, $parameters);

        $this->getSizes($parameters);

        $this->setAdditionalWorks($calculatedCalculator, $parameters, $isBlockSelect);
        $this->setDeparture($calculatedCalculator, $parameters);

        if (isset($parameters->quantity_types)) {
            $quantityTypes = explode(',', $parameters->quantity_types);

            if (count($quantityTypes) > 1) {
                $parameters->product_count = array_sum($quantityTypes);
            }
        }

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

        $calculatedCalculator->getBeforeTotal($parameters, $this->calculator);
        $calculatedCalculator->getTotalPrice();

        $calc = $calculatedCalculator->getCalculable();

        return $this->resultResponse($calc);
    }

    /**
     * Устанавливает параметры если
     * @param CalculatedCalculator $calculatedCalculator
     * @param object $parameters
     * @return void
     */
    private function setBlockSelectData(CalculatedCalculator &$calculatedCalculator, object $parameters): void
    {
        $this->setBlockWorkAdditionals($calculatedCalculator, $parameters);
    }

    private function setBlockWorkAdditionals(CalculatedCalculator &$calculator, object $parameters): void
    {
        if (isset($parameters->embossing_face1_select_visitki_vip_face_select)) {
            WorkAdditionalService::setCalculatorWorks($calculator, [
                'foiling_id' => $parameters->embossing_face1_select_visitki_vip_face_select,
                'calculator_id' => $this->calculator->id,
            ]);
        }

        if (isset($parameters->embossing_face2_select_visitki_vip_face_select)) {
            WorkAdditionalService::setCalculatorWorks($calculator, [
                'foiling_id' => $parameters->embossing_face2_select_visitki_vip_face_select,
                'calculator_id' => $this->calculator->id,
            ]);
        }

        if (isset($parameters->embossing_back1_select_visitki_vip_back_select)) {
            WorkAdditionalService::setCalculatorWorks($calculator, [
                'foiling_id' => $parameters->embossing_back1_select_visitki_vip_back_select,
                'calculator_id' => $this->calculator->id,
            ]);
        }

        if (isset($parameters->embossing_back2_select_visitki_vip_back_select)) {
            WorkAdditionalService::setCalculatorWorks($calculator, [
                'foiling_id' => $parameters->embossing_back2_select_visitki_vip_back_select,
                'calculator_id' => $this->calculator->id,
            ]);
        }
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

        if (isset($parameters->print_type)) {
            $specieType->wherePivot('print_id', $parameters->print_type);
        }

        $specieType = $specieType->first();
        $duplex = false;

        if (isset($parameters->color)) {
            $color = Color::query()->find($parameters->color);
            $duplex = $color->is_two_side;
        } elseif (isset($parameters->print_type)) {
            $color = $this->calculator
                ->colors()
                ->where('print_id', $parameters->print_type)
                ->first();
            $duplex = $color->is_two_side;
        }

        if ($specieType) {
            $calculatedCalculator->setPrint(
                $specieType->id,
                $duplex,
                checkSizes: true,
                useExtraMaxSize: true,
                isNotUseDeparture: true,
            );
        }
    }

    /**
     * Устанавливает доп работы для подсчётного калькулятора в зависимости от переданных параметров
     * @param CalculatedCalculator $calculatedCalculator
     * @param object $parameters
     * @param bool|null $isBlockSelect
     * @return void
     */
    private function setAdditionalWorks(
        CalculatedCalculator &$calculatedCalculator,
        object $parameters,
        bool $isBlockSelect = null,
    ): void {
        $this->setBasicAdditionalWorks($calculatedCalculator, $parameters);

        $this->setEmbossingWorkAdditionals($calculatedCalculator, $parameters);

        WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
            'calculator_id' => $this->calculator->id,
        ]);

        if ($isBlockSelect && ($parameters->color_count_face || $parameters->color_count_back)) {
            WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                'calculator_id' => $this->calculator->id,
                'is_grid' => true,
            ]);
        }

        if (isset($parameters->foiling_face)) {
            WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                'foiling_id' => $parameters->foiling_face,
            ]);
        }

        if (isset($parameters->foiling_back)) {
            WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                'foiling_id' => $parameters->foiling_back,
            ]);
        }

        if (isset($parameters->foiling_face) && isset($parameters->material)) {
            WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                'foiling_id' => $parameters->foiling_face,
                'material_id' => $parameters->material,
            ]);
        }

        if (isset($parameters->foiling_back) && isset($parameters->material)) {
            WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                'foiling_id' => $parameters->foiling_back,
                'material_id' => $parameters->material,
            ]);
        }

        if (isset($parameters->lam) && $parameters->lam) {
            WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                'lamination_id' => (int) $parameters->lam,
            ]);
        }

        if (
            isset($parameters->congregation) &&
            isset($parameters->cliche) &&
            $parameters->congregation &&
            $parameters->cliche
        ) {
            WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                'calculator_id' => $this->calculator->id,
                'is_congregation' => true,
                'is_cliche' => true,
            ]);
        }

        if (isset($parameters->quantity_types)) {
            $quantityTypes = explode(',', $parameters->quantity_types);

            if (count($quantityTypes) > 1) {
                WorkAdditionalService::setCalculatorWorks(
                    $calculatedCalculator,
                    [
                        'is_quantity_types' => 1,
                    ],
                    count($quantityTypes),
                );
            }
        }
    }

    /**
     * @param CalculatedCalculator $calculatedCalculator
     * @param object $parameters
     * @return void
     */
    private function setBasicAdditionalWorks(CalculatedCalculator &$calculatedCalculator, object $parameters): void
    {
        $addWorksConditions = [
            'form' => [
                [
                    'calculator_id' => $this->calculator->id,
                    'print_form_id' => $parameters->form ?? null,
                ],
            ],
            'foiling_face' => [
                [
                    'calculator_id' => $this->calculator->id,
                    'foiling_face' => $this->calculator->calculatorType->foilingColorsWithoutNone
                        ->keyBy('id')
                        ->contains($parameters->foiling_face ?? null),
                ],
            ],
            'foiling_back' => [
                [
                    'calculator_id' => $this->calculator->id,
                    'foiling_face' => $this->calculator->calculatorType->foilingColorsWithoutNone
                        ->keyBy('id')
                        ->contains($parameters?->foiling_back ?? null),
                ],
            ],
            'rounding_corners' => [
                [
                    'calculator_id' => $this->calculator->id,
                    'is_rounding_corners' => true,
                ],
            ],
            'congregation' => [
                [
                    'calculator_id' => $this->calculator->id,
                    'is_congregation' => true,
                ],
            ],
            'varnish_face' => [
                [
                    'calculator_id' => $this->calculator->id,
                    'is_varnish_face' => true,
                ],
                [
                    'is_varnish_face' => true,
                ],
            ],
            'varnish_face_visitki_vip_face_select' => [
                [
                    'calculator_id' => $this->calculator->id,
                    'is_varnish_face' => true,
                ],
                [
                    'is_varnish_face' => true,
                ],
            ],
            'varnish_back' => [
                [
                    'calculator_id' => $this->calculator->id,
                    'is_varnish_back' => true,
                ],
                [
                    'is_varnish_back' => true,
                ],
            ],
            'varnish_back_visitki_vip_back_select' => [
                [
                    'calculator_id' => $this->calculator->id,
                    'is_varnish_back' => true,
                ],
                [
                    'is_varnish_back' => true,
                ],
            ],
            'thermal_rise_face' => [
                [
                    'calculator_id' => $this->calculator->id,
                    'is_thermal_rise_face' => true,
                ],
                [
                    'is_thermal_rise_face' => true,
                ],
            ],
            'thermal_rise_face_visitki_vip_face_select' => [
                [
                    'calculator_id' => $this->calculator->id,
                    'is_thermal_rise_face' => true,
                ],
                [
                    'is_thermal_rise_face' => true,
                ],
            ],
            'thermal_rise_back' => [
                [
                    'calculator_id' => $this->calculator->id,
                    'is_thermal_rise_back' => true,
                ],
                [
                    'is_thermal_rise_back' => true,
                ],
            ],
            'thermal_rise_back_visitki_vip_back_select' => [
                [
                    'calculator_id' => $this->calculator->id,
                    'is_thermal_rise_back' => true,
                ],
                [
                    'is_thermal_rise_back' => true,
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
     * Устанавливает доп работы для тиснения
     * @param CalculatedCalculator $calculatedCalculator
     * @param object $parameters
     * @return void
     */
    private function setEmbossingWorkAdditionals(CalculatedCalculator &$calculatedCalculator, object $parameters): void
    {
        if (!(isset($parameters->cliche) && $parameters->cliche)) {
            return;
        }

        $fields = [
            'embossing_face1_select_visitki_vip_face_select',
            'embossing_face2_select_visitki_vip_face_select',
            'embossing_back1_select_visitki_vip_back_select',
            'embossing_back2_select_visitki_vip_back_select',
        ];

        foreach ($fields as $field) {
            if (isset($parameters->$field)) {
                $foiling = Foiling::query()->find($parameters->$field);

                if ($foiling->is_none) {
                    continue;
                }

                WorkAdditionalService::setCalculatorWorks($calculatedCalculator, [
                    'is_cliche' => true,
                    'is_congregation' => !!$foiling?->is_congregation,
                ]);
            }
        }
    }

    /**
     * @param CalculatedCalculator $calculatedCalculator
     * @param object $parameters
     * @return void
     */
    private function setDeparture(CalculatedCalculator &$calculatedCalculator, object $parameters): void
    {
        if ($this->calculator->departure) {
            $departure = $this->calculator->departure->value;
        } elseif (isset($parameters->form) && $parameters->form != self::RECTANGLE_FORM_ID) {
            $departure = PrintForm::find($parameters->form)->departure->value;
        } else {
            $departure = self::DEPARTURE_DEFAULT;
        }

        $calculatedCalculator->setDeparture($departure);
    }
}
