<?php

namespace App\Orchid\Layouts\Print\Species;

use App\Models\PrintSpecie;
use App\Orchid\Custom\CustomTD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PrintSpeciesListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'printSpecies';

    protected string $editRoute = 'platform.print.specie.edit';

    protected function columns(): iterable
    {
        return [
            TD::make('id', 'id')->sort(),
            TD::make('sequence', 'Порядок')->sort(),
            TD::make('name', 'Название'),
            TD::make('volume', 'Площадь')->sort(),

            TD::make('materials', 'База')
                ->width(30)
                ->alignCenter()
                ->render(
                    fn (PrintSpecie $printSpecie) => Link::make('перейти')
                        ->icon('arrow-right')
                        ->route('platform.module.print.materials', [
                            'filter[print_specie_id]' => $printSpecie->id,
                        ]),
                ),

            TD::make('action', 'Действие')->render(function (PrintSpecie $printSpecie) {
                return CustomTD::make()->optionButtons('platform.print.specie.edit', $printSpecie);
            }),
        ];
    }
}
