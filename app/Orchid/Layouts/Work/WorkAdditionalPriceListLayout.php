<?php

namespace App\Orchid\Layouts\Work;

use App\Models\WorkAdditionalPrice;
use App\Orchid\Custom\CustomTD;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;

class WorkAdditionalPriceListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'workAdditionalPrices';

    protected string $editRoute = 'platform.works.additional.price.edit';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('list_meters', 'Длина листа (???)')->sort(),
            TD::make('circulation', 'Обращение')->sort(),
            TD::make('price', 'Цена')->sort(),
            TD::make('fixed_sum', 'Фиксированная сумма')->sort(),
            TD::make('percent', 'Проценты')->sort(),
            TD::make('charge')->sort(),
            TD::make('work_additional.0.name', 'Доп. работа')
                ->render(function (WorkAdditionalPrice $price) {
                    $workAdditional = $price->workAdditional()->first();

                    return Link::make($workAdditional?->name)->route('platform.works.additional.edit', $workAdditional);
                })
                ->sort(),

            TD::make('action', 'Действие')->render(function (WorkAdditionalPrice $workAdditionalPrice) {
                return CustomTD::make()->optionButtons('platform.works.additional.price.edit', $workAdditionalPrice);
            }),
        ];
    }
}
