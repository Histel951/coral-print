<?php

namespace App\Orchid\Layouts\Pivot;

use App\Models\PivotCalculatorCutting;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;

class CalculatorCuttingListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'calculatorCuttings';

    protected string $editRoute = 'platform.pivot.calculator.cutting.edit';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('calculator.name', 'Калькулятор')->render(function (PivotCalculatorCutting $calculatorCutting) {
                return Link::make($calculatorCutting->calculator->name)->route(
                    'platform.calculator.edit',
                    $calculatorCutting->calculator,
                );
            }),

            TD::make('cutting.name', 'Нарезка')->render(function (PivotCalculatorCutting $calculatorCutting) {
                return Link::make($calculatorCutting->cutting->name)->route(
                    'platform.cutting.edit',
                    $calculatorCutting->cutting,
                );
            }),
        ];
    }
}
