<?php

namespace App\Orchid\Layouts\Design;

use App\Orchid\Filters\Design\DesignPriceFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class DesignPriceSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [DesignPriceFilter::class];
    }
}
