<?php

namespace App\Orchid\Layouts\Design;

use App\Orchid\Filters\Design\DesignFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class DesignSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [DesignFilter::class];
    }
}
