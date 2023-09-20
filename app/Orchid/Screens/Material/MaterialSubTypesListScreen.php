<?php

namespace App\Orchid\Screens\Material;

use App\Models\MaterialSubType;
use App\Orchid\Layouts\Material\MaterialSubTypesListLayout;
use App\Orchid\Layouts\Material\MaterialTypeSubSelection;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class MaterialSubTypesListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'materialSubTypes' => MaterialSubType::with(['material'])
                ->filtersApplySelection(MaterialTypeSubSelection::class)
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
        return 'Подтипы материалов';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Link::make('Создать')->route('platform.material.sub.type.create')];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [MaterialTypeSubSelection::class, MaterialSubTypesListLayout::class];
    }
}
