<?php

namespace App\Orchid\Layouts\Design;

use App\Models\DesignCategory;
use App\Orchid\Custom\CustomTD;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DesignCategoryListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'designPrices';

    protected string $editRoute = 'platform.design.category.edit';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('name', 'Название'),

            TD::make('action', 'Действие')->render(function (DesignCategory $designCategory) {
                return CustomTD::make()->optionButtons('platform.design.category.edit', $designCategory);
            }),
        ];
    }
}
