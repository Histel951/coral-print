<?php

namespace App\Orchid\Layouts\Material;

use App\Orchid\Filters\Material\MaterialTypeFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class MaterialTypeSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [MaterialTypeFilter::class];
    }
}
