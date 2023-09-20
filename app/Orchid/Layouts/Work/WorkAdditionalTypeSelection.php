<?php

namespace App\Orchid\Layouts\Work;

use App\Orchid\Filters\Work\WorkAdditionalTypeFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class WorkAdditionalTypeSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [WorkAdditionalTypeFilter::class];
    }
}
