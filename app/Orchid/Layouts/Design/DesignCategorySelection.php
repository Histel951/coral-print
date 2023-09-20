<?php

namespace App\Orchid\Layouts\Design;

use App\Orchid\Filters\Design\DesignCategoryFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class DesignCategorySelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [DesignCategoryFilter::class];
    }
}
