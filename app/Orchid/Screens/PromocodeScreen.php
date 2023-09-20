<?php

namespace App\Orchid\Screens;

use App\Models\Promocode;
use App\Orchid\Layouts\PromocodeSelection;
use App\Orchid\Layouts\PromocodeTable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class PromocodeScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'table' => Promocode::filters()
                ->filtersApplySelection(PromocodeSelection::class)
                ->defaultSort('id', 'desc')
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
        return 'Промокоды';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Link::make('Создать')->route('platform.promocode.create')];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [PromocodeSelection::class, PromocodeTable::class];
    }
}
