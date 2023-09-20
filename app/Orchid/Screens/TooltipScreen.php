<?php

namespace App\Orchid\Screens;

use App\Models\Tooltip;
use App\Orchid\Layouts\TooltipSelection;
use App\Orchid\Layouts\TooltipTable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class TooltipScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'table' => Tooltip::filters()
                ->filtersApplySelection(TooltipSelection::class)
                ->defaultSort('id')
                ->paginate(20),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Подсказки';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Link::make('Создать')->route('platform.tooltip.create')];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [TooltipSelection::class, TooltipTable::class];
    }
}
