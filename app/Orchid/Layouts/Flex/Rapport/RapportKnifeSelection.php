<?php

namespace App\Orchid\Layouts\Flex\Rapport;

use App\Orchid\Filters\Flex\Rapport\RapportKnifeFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class RapportKnifeSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            RapportKnifeFilter::class
        ];
    }
}
