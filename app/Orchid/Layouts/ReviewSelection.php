<?php

namespace App\Orchid\Layouts;

use App\Orchid\Filters\ReviewFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class ReviewSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [ReviewFilter::class];
    }
}
