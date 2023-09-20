<?php

namespace App\Orchid\Layouts;

use App\Models\PivotCalculatorPrints;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;

class CalculatorPrintListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'calculatorPrints';

    protected string $editRoute = 'platform.pivot.calculator.print.edit';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('calculator.name', 'Калькулятор')
                ->render(function (PivotCalculatorPrints $calculatorPrints) {
                    if ($name = $calculatorPrints->calculator?->name) {
                        return Link::make($name)->route('platform.calculator.edit', $calculatorPrints->calculator);
                    }

                    return '';
                })
                ->sort(),

            TD::make('print.name', 'Печать')
                ->render(function (PivotCalculatorPrints $calculatorPrints) {
                    return Link::make($calculatorPrints->print->name)->route(
                        'platform.print.edit',
                        $calculatorPrints->print,
                    );
                })
                ->sort(),

            TD::make('calculator_sub.name', 'Под калькулятор')->sort(),
        ];
    }
}
