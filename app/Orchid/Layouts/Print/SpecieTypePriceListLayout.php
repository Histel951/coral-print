<?php

namespace App\Orchid\Layouts\Print;

use App\Models\SpecieTypePrice;
use App\Orchid\Custom\CustomTD;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\TD;

class SpecieTypePriceListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'specieTypePrices';

    protected string $editRoute = 'platform.print.specie.type.price.edit';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('quantity', 'Количество'),
            TD::make('price', 'Цена'),
            TD::make('overprice', 'Наценка'),
            TD::make('specie_type.name', 'Тип разновидности печати'),

            TD::make('action', 'Действие')->render(function (SpecieTypePrice $specieTypePrice) {
                return CustomTD::make()->optionButtons('platform.print.specie.type.price.edit', $specieTypePrice);
            }),
        ];
    }
}
