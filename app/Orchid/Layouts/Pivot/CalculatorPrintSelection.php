<?php

namespace App\Orchid\Layouts\Pivot;

use App\Orchid\Filters\Pivot\PivotCalculatorFilter;
use App\Orchid\Filters\Pivot\PivotCalculatorSubFilter;
use App\Orchid\Filters\Pivot\PivotPrintFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class CalculatorPrintSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [PivotCalculatorFilter::class, PivotPrintFilter::class, PivotCalculatorSubFilter::class];
    }
}
