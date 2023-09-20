<?php

namespace App\Orchid\Layouts\Material;

use App\Orchid\Filters\Material\MaterialTypeSubFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class MaterialTypeSubSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [MaterialTypeSubFilter::class];
    }
}
