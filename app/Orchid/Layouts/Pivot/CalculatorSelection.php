<?php

namespace App\Orchid\Layouts\Pivot;

use App\Orchid\Filters\Calculator\CalculatorFilter;
use App\Orchid\Filters\Pivot\CalculatorTypeFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class CalculatorSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [CalculatorFilter::class, CalculatorTypeFilter::class];
    }
}
