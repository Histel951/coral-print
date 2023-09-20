<?php

namespace App\Orchid\Layouts\Pivot;

use App\Models\PivotCalculatorLamination;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;

class CalculatorLaminationListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'laminations';

    protected string $editRoute = 'platform.pivot.calculator.lamination.edit';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('calculator.name', 'Калькулятор')->render(function (
                PivotCalculatorLamination $calculatorLamination,
            ) {
                if ($name = $calculatorLamination->calculator?->name) {
                    return Link::make($name)->route('platform.calculator.edit', $calculatorLamination->calculator);
                }

                return '';
            }),

            TD::make('lamination.name', 'Ламинация')->render(function (
                PivotCalculatorLamination $calculatorLamination,
            ) {
                if ($name = $calculatorLamination->lamination?->name) {
                    return Link::make($name)->route('platform.lamination.edit', $calculatorLamination->lamination);
                }

                return '';
            }),

            TD::make('print_.name', 'Печать')->render(function (PivotCalculatorLamination $calculatorLamination) {
                if ($name = $calculatorLamination->print_?->name) {
                    return Link::make($name)->route('platform.print.edit', $calculatorLamination->print_);
                }

                return '';
            }),

            TD::make('calculator_sub.name', 'Калькулятор')->render(function (
                PivotCalculatorLamination $calculatorLamination,
            ) {
                if ($name = $calculatorLamination->calculator_sub?->name) {
                    return Link::make($name)->route('platform.calculator.edit', $calculatorLamination->calculator_sub);
                }

                return '';
            }),
        ];
    }
}
