<?php

namespace App\Orchid\Screens\Design;

use App\Models\Design;
use App\Orchid\Layouts\Design\DesignListLayout;
use App\Orchid\Layouts\Design\DesignSelection;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class DesignListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'designs' => Design::with(['calculatorType', 'subcategory'])
                ->filtersApplySelection(DesignSelection::class)
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
        return 'Дизайн';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Link::make('Создать')->route('platform.design.create')];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [DesignSelection::class, DesignListLayout::class];
    }
}
