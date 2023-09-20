<?php

namespace App\Orchid\Layouts\Design;

use App\Orchid\Filters\Design\DesignSubcategoryFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class DesignSubcategorySelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [DesignSubcategoryFilter::class];
    }
}
