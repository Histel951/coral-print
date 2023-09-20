<?php

namespace App\Orchid\Layouts\Flex;

use App\Orchid\Filters\Flex\FlexMaterialFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class FlexMaterialSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [FlexMaterialFilter::class];
    }
}
