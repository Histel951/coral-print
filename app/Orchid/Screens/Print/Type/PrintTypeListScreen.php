<?php

namespace App\Orchid\Screens\Print\Type;

use App\Models\PrintSpecie;
use App\Orchid\Layouts\Print\PrintSpeciesSelection;
use App\Orchid\Layouts\Print\Species\PrintSpeciesListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class PrintTypeListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'printSpecies' => PrintSpecie::with(['printType'])
                ->filtersApplySelection(PrintSpeciesSelection::class)
                ->filters()
                ->defaultSort('sequence')
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
        return 'Типы печати';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Link::make('Создать')->route('platform.print.type.create')];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [PrintSpeciesSelection::class, PrintSpeciesListLayout::class];
    }
}
