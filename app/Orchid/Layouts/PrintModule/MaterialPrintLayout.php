<?php

namespace App\Orchid\Layouts\PrintModule;

use App\Models\Material;
use App\Orchid\Custom\CustomTD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class MaterialPrintLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'materials';

    protected string $editRoute = 'platform.material.edit';

    protected function columns(): iterable
    {
        return [
            TD::make('id', 'id')->sort(),
            TD::make('sequence', 'Порядок')->sort(),
            TD::make('name', 'Название'),

            TD::make('category.name', 'Категория'),

            TD::make('action', 'Действие')->render(function (Material $material) {
                return CustomTD::make()->optionButtons('platform.print.material.edit', $material);
            }),
        ];
    }
}
