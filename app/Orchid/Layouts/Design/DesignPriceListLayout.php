<?php

namespace App\Orchid\Layouts\Design;

use App\Models\DesignPrice;
use App\Orchid\Custom\CustomTD;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\TD;

class DesignPriceListLayout extends StandardTable
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

    protected string $editRoute = 'platform.design.price.edit';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('sort', 'Порядок'),
            TD::make('name', 'Название'),
            TD::make('value', 'Цена')->sort(),

            TD::make('action', 'Действие')->render(function (DesignPrice $designPrice) {
                return CustomTD::make()->optionButtons('platform.design.price.edit', $designPrice);
            }),
        ];
    }
}
