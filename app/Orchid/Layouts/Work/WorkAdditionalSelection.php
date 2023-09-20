<?php

namespace App\Orchid\Layouts\Work;

use App\Orchid\Filters\Work\WorkAdditionalFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class WorkAdditionalSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [WorkAdditionalFilter::class];
    }
}
