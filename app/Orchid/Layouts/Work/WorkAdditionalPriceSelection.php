<?php

namespace App\Orchid\Layouts\Work;

use App\Orchid\Filters\Work\WorkAdditionalPriceFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class WorkAdditionalPriceSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [WorkAdditionalPriceFilter::class];
    }
}
