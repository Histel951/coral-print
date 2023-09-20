<?php

namespace App\Orchid\Layouts;

use App\Orchid\Filters\TooltipFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class TooltipSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [TooltipFilter::class];
    }
}
