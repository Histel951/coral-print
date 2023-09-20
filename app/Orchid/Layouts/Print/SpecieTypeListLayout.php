<?php

namespace App\Orchid\Layouts\Print;

use App\Models\SpecieType;
use App\Orchid\Custom\CustomTD;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\TD;

class SpecieTypeListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'specieType';

    protected string $editRoute = 'platform.print.specie.type.edit';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function standardColumns(): iterable
    {
        return [
            TD::make('name', 'Название'),

            TD::make('action', 'Действие')->render(function (SpecieType $specieType) {
                return CustomTD::make()->optionButtons('platform.print.specie.type.edit', $specieType);
            }),
        ];
    }
}
