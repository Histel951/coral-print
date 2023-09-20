<?php

namespace App\Orchid\Layouts\Pivot;

use App\Orchid\Filters\Pivot\CalculatorTypeMainFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class CalculatorTypeSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [CalculatorTypeMainFilter::class];
    }
}
