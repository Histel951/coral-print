<?php

namespace App\Orchid\Layouts\Design;

use App\Models\DesignSubcategory;
use App\Orchid\Custom\CustomTD;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DesignSubcategoryListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'designSubcategories';

    protected string $editRoute = 'platform.design.subcategory.edit';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('name', 'Название'),

            TD::make('category.name', 'Категория')->render(function (DesignSubcategory $designSubcategory) {
                return Link::make($designSubcategory->name)->route('platform.design.category.edit', $designSubcategory);
            }),

            TD::make('action', 'Действие')->render(function (DesignSubcategory $designSubcategory) {
                return CustomTD::make()->optionButtons('platform.design.subcategory.edit', $designSubcategory);
            }),
        ];
    }
}
