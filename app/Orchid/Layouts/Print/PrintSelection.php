<?php

namespace App\Orchid\Layouts\Print;

use App\Orchid\Filters\Print\PrintFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class PrintSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [PrintFilter::class];
    }
}
