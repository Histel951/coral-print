<?php

namespace App\Orchid\Layouts;

use App\Orchid\Filters\PromocodeFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class PromocodeSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [PromocodeFilter::class];
    }
}
