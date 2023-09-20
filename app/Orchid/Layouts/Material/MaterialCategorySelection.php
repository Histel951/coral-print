<?php

namespace App\Orchid\Layouts\Material;

use App\Orchid\Filters\Material\MaterialCategoryFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class MaterialCategorySelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [MaterialCategoryFilter::class];
    }
}
