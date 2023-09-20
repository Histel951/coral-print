<?php

namespace App\Orchid\Layouts\Preview;

use App\Orchid\Filters\Preview\PreviewParametersFilter;
use App\Orchid\Filters\Preview\PreviewReferenceFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class PreviewSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [PreviewParametersFilter::class, PreviewReferenceFilter::class];
    }
}
