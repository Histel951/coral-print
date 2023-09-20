<?php

namespace App\Orchid\Layouts\Material;

use App\Models\MaterialCategory;
use App\Orchid\Custom\CustomTD;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class MaterialCategoryListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'materialCategory';

    protected string $editRoute = 'platform.material.category.edit';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('name', 'Название'),

            TD::make('action', 'Действие')->render(function (MaterialCategory $materialCategory) {
                return CustomTD::make()->optionButtons('platform.material.category.edit', $materialCategory);
            }),
        ];
    }
}
