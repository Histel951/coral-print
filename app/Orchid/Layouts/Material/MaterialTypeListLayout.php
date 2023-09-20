<?php

namespace App\Orchid\Layouts\Material;

use App\Models\MaterialType;
use App\Orchid\Custom\CustomTD;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;

class MaterialTypeListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'material_types';

    protected string $editRoute = 'platform.material.type.edit';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('name', 'Название'),
            TD::make('type_name', 'Название типа'),
            TD::make('sort', 'Сортировка')->sort(),

            TD::make('materials', 'Материалы')->render(function (MaterialType $materialType) {
                return Link::make('перейти')->icon('arrow-right');
            }),

            TD::make('action', 'Действие')->render(function (MaterialType $materialType) {
                return CustomTD::make()->optionButtons('platform.material.type.edit', $materialType);
            }),
        ];
    }
}
