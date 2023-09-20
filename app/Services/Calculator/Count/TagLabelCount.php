<?php

namespace App\Services\Calculator\Count;

use App\Models\Calculator;
use App\Services\Calculator\Count\Algorithms\CalculatorFlexa;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;

class TagLabelCount implements CalculatorCount
{
    use CountLeading;

    public function __construct(private readonly Calculator $calculator)
    {
    }

    /**
     * @param array $parameters
     * @return array
     * @throws BindingResolutionException
     */
    public function get(array $parameters = []): array
    {
        $parameters = (object) $parameters;
        $calculatedCalculator = new CalculatorFlexa($this->calculator);

        if (isset($parameters->thermal)) {
            $calculatedCalculator->setThermal($parameters->thermal);
        }

        $isDummy = (int) ($parameters?->dummy ?? 0);

        $calculatedCalculator->setKnife($parameters->knife, (bool) $isDummy);
        $calculatedCalculator->setMaterial($parameters->material);

        if (isset($parameters->paint)) {
            $calculatedCalculator->setCustomPaints(json_decode($parameters->paint));
        }

        if (isset($parameters->color_paints)) {
            $calculatedCalculator->setColor($parameters->color_paints);
        }

        if (isset($parameters->ribbon)) {
            $calculatedCalculator->setRibbon($parameters->ribbon);
        }

        if (isset($parameters->sleeve_quantity)) {
            $calculatedCalculator->setSleeveQuantity($parameters->sleeve_quantity);
        }

        $calculatedCalculator->setForm($parameters->form ?? null);

        $productCount = $parameters->product_count;

        if (isset($parameters->rolls)) {
            $productCount *= $parameters->rolls;
        }

        $calculatedCalculator->setProductCount($productCount);
        $calculatedCalculator->setCount();
        $calculatedCalculator->setPrint();

        $calculatedCalculator->setAddJob($parameters);
        $calculatedCalculator->setRibbonMaterials(isset($parameters->ribbon) ? ['ribbon'] : []);

        $totalPrice = $calculatedCalculator->getTotalPrice();
        $itemPrice = $calculatedCalculator->getItemPrice();
        $calculable = $calculatedCalculator->getCalculable();

        return Arr::collapse([
            ['repeat_circulation' => $calculatedCalculator->getRepeatCirculationPrice()],
            $this->resultResponse(
                [...$calculable, 'result_total_price' => $totalPrice, 'count_item_price' => $itemPrice],
                'calc.debug.flex_debug_template',
            )
        ]);
    }
}
