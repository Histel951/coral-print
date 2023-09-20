<?php

namespace App\Orchid\Screens;

use App\Models\CalculatorType;
use App\Orchid\Layouts\GalleryCategoriesListTable;
use App\Orchid\Layouts\Pivot\CalculatorTypeSelection;
use Orchid\Screen\Screen;

class GalleryCategoriesListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'calculator_types' => CalculatorType::filtersApplySelection(CalculatorTypeSelection::class)
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
        return 'Разделы';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [GalleryCategoriesListTable::class];
    }
}
