<?php

namespace App\Orchid\Layouts\Material;

use App\Orchid\Filters\Material\MaterialFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class MaterialSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [MaterialFilter::class];
    }
}
