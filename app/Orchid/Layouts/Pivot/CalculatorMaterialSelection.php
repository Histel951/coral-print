<?php

namespace App\Orchid\Layouts\Pivot;

use App\Orchid\Filters\Pivot\PivotCalculatorFilter;
use App\Orchid\Filters\Pivot\PivotMaterialFilter;
use App\Orchid\Filters\Pivot\PivotPrintFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class CalculatorMaterialSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [PivotCalculatorFilter::class, PivotMaterialFilter::class, PivotPrintFilter::class];
    }
}
