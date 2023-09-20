<?php

namespace App\Orchid\Layouts\Print;

use App\Orchid\Filters\Print\PrintSpeciesFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class PrintSpeciesSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [PrintSpeciesFilter::class];
    }
}
