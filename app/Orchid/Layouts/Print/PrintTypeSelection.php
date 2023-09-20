<?php

namespace App\Orchid\Layouts\Print;

use App\Orchid\Filters\Print\PrintTypeFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class PrintTypeSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [PrintTypeFilter::class];
    }
}
