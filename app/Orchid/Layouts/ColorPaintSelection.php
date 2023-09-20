<?php

namespace App\Orchid\Layouts;

use App\Orchid\Filters\ColorPaintFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class ColorPaintSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [ColorPaintFilter::class];
    }
}
