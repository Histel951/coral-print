<?php

namespace App\Orchid\Layouts\Pivot;

use App\Orchid\Filters\Pivot\PivotCalculatorFilter;
use App\Orchid\Filters\Pivot\PivotCuttingFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class CalculatorCuttingSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [PivotCalculatorFilter::class, PivotCuttingFilter::class];
    }
}
