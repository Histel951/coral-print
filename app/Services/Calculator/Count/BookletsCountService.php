<?php

namespace App\Services\Calculator\Count;

use App\Models\Calculator;
use App\Models\Color;
use App\Services\Calculator\CalculatorService;
use App\Services\Calculator\Config\BookletMaterialService;
use App\Services\Calculator\Count\Algorithms\Calculator as CountCalculator;
use App\Services\Calculator\Count\Algorithms\CalculatorMaster;
use App\Services\Calculator\Count\Util\Exceptions\PrintSizeException;
use App\Services\Calculator\WorkAdditionalService;
use Exception;
use Illuminate\Support\Facades\DB;

class BookletsCountService implements CalculatorCount
{
    use CountLeading;

    /**
     * Сервис калькуляторов
     * @var BookletMaterialService
     */
    private BookletMaterialService $materialService;

    /**
     * Модель калькулятора
     * @var Calculator
     */
    private Calculator $calculator;

    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
        $calculatorService = app()->make(CalculatorService::class, [
            'calculator' => $calculator,
        ]);
        $this->materialService = $calculatorService->material();
    }

    /**
     * @param array $parameters
     * @return array
     * @throws Exception
     */
    public function get(array $parameters = []): array
    {
        $parameters = (object) $parameters;

        $countCalculator = new CalculatorMaster($this->calculator);
        $countCalculator->debugOn();
        $countCalculator->setDeparture();

        $countCalculator->setType($parameters->type);
        $countCalculator->setMaterial($parameters->material);
        $countCalculator->setProductCount($parameters->product_count);
        $countCalculator->setLayoutSize($parameters->width, $parameters->height);

        try {
            $this->setPrint($countCalculator, $parameters);
        } catch (PrintSizeException $exception) {
            return $this->printErrorResponse($exception, $parameters);
        }

        $this->workAdditionals($countCalculator, $parameters);

        if (isset($parameters->discount)) {
            return $this->discountResponse($countCalculator, $parameters);
        }

        $countCalculator->getTotalPrice();
        $calculable = $countCalculator->getCalculable();

        return $this->resultResponse($calculable);
    }

    /**
     * @param CountCalculator $countCalculator
     * @param object $parameters
     * @return void
     * @throws PrintSizeException
     */
    private function setPrint(CountCalculator $countCalculator, object $parameters): void
    {
        $isDuplex = false;
        $specieType = $this->materialService->specieType(
            width: (int) $parameters->width,
            height: (int) $parameters->height,
            colorId: isset($parameters->print_select) ? (int) $parameters->print_select : null,
        );

        if (isset($parameters->print_select)) {
            $isDuplex = (bool) Color::query()->find($parameters->print_select)->is_two_side;
        }

        if (
            isset($this->calculator->parameters['is_two_side_print']) &&
            $this->calculator->parameters['is_two_side_print']
        ) {
            $isDuplex = $this->calculator->parameters['is_two_side_print'];
        }

        if ($specieType) {
            $countCalculator->setPrint(
                printId: $specieType->id,
                duplex: $isDuplex,
                checkSizes: true,
                checkSpecieTypeId: $this->getBiggerSpecieTypeId(),
            );
        }
    }

    /**
     * Возвращает ID максимально возможной по размеру печати
     * @return int
     */
    private function getBiggerSpecieTypeId(): int
    {
        return collect(
            DB::select("select
                                IF(st.width > st.height, st.width, st.height) bigger,
                                st.id as id,
                                pcst.is_duplex,
                                st.print_specie_id
                          from pivot_calculator_specie_types pcst
                                left join specie_types st
                                    on pcst.specie_type_id = st.id
                                where pcst.calculator_id = {$this->calculator->id}
                          order by bigger desc"),
        )->first()->id;
    }

    /**
     * @param CountCalculator $calculator
     * @param object $parameters
     * @return void
     */
    private function workAdditionals(CountCalculator &$calculator, object $parameters): void
    {
        WorkAdditionalService::setCalculatorWorks($calculator, [
            'calculator_id' => $this->calculator->id,
        ]);

        if (isset($parameters->fold_count)) {
            WorkAdditionalService::setCalculatorWorks(
                $calculator,
                [
                    'calculator_id' => $this->calculator->id,
                    'is_folds' => true,
                ],
                (int) $parameters->fold_count ?? 1,
            );
        }

        if (isset($parameters->varnish_face) && (int) $parameters->varnish_face) {
            WorkAdditionalService::setCalculatorWorks($calculator, [
                'calculator_id' => $this->calculator->id,
                'is_varnish_face' => (int) $parameters->varnish_face,
            ]);
        }

        if (isset($parameters->varnish_back) && (int) $parameters->varnish_back) {
            WorkAdditionalService::setCalculatorWorks($calculator, [
                'calculator_id' => $this->calculator->id,
                'is_varnish_face' => (int) $parameters->varnish_back,
            ]);
        }

        if (isset($parameters->foiling)) {
            WorkAdditionalService::setCalculatorWorks($calculator, [
                'foiling_id' => (int) $parameters->foiling,
                'calculator_id' => $this->calculator->id,
            ]);
        }

        if (isset($parameters->lam)) {
            $specieType = $this->materialService->specieType(
                width: (int) $parameters->width,
                height: (int) $parameters->height,
                colorId: isset($parameters->print_select) ? (int) $parameters->print_select : null,
            );

            WorkAdditionalService::setCalculatorWorks($calculator, [
                'lamination_id' => $parameters->lam,
                'calculator_id' => $this->calculator->id,
                'print_specie_id' => $specieType?->print_specie_id ?? null,
            ]);
        }
    }
}
