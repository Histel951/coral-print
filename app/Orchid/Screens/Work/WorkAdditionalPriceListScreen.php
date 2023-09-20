<?php

namespace App\Orchid\Screens\Work;

use App\Models\WorkAdditionalPrice;
use App\Orchid\Layouts\Work\WorkAdditionalPriceListLayout;
use App\Orchid\Layouts\Work\WorkAdditionalPriceSelection;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class WorkAdditionalPriceListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'workAdditionalPrices' => WorkAdditionalPrice::with(['workAdditional'])
                ->filtersApplySelection(WorkAdditionalPriceSelection::class)
                ->filters()
                ->defaultSort('id')
                ->paginate(),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Цены доп. работ';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Link::make('Создать')->route('platform.works.additional.price.create')];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [WorkAdditionalPriceSelection::class, WorkAdditionalPriceListLayout::class];
    }
}
