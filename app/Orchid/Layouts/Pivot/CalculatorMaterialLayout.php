<?php

namespace App\Orchid\Layouts\Pivot;

use App\Models\PivotCalculatorMaterial;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;

class CalculatorMaterialLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'materialCalculator';

    protected string $editRoute = 'platform.pivot.calculator.material.edit';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('calculator.name', 'Калькулятора')
                ->render(function (PivotCalculatorMaterial $calculatorMaterial) {
                    if ($name = $calculatorMaterial->calculator?->name) {
                        return Link::make($name)->route('platform.calculator.edit', $calculatorMaterial->calculator);
                    }

                    return '';
                })
                ->sort(),

            TD::make('material.name', 'Материал')
                ->render(function (PivotCalculatorMaterial $calculatorMaterial) {
                    if ($name = $calculatorMaterial->material?->name) {
                        return Link::make($name)->route('platform.material.edit', $calculatorMaterial->material);
                    }

                    return '';
                })
                ->sort(),

            TD::make('print.name', 'Печать')
                ->render(function (PivotCalculatorMaterial $calculatorMaterial) {
                    if ($name = $calculatorMaterial->print_?->name) {
                        return Link::make($name)->route('platform.print.edit', $calculatorMaterial->print_);
                    }

                    return '';
                })
                ->sort(),
        ];
    }
}
