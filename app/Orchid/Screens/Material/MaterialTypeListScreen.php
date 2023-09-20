<?php

namespace App\Orchid\Screens\Material;

use App\Models\MaterialType;
use App\Orchid\Layouts\Material\MaterialTypeListLayout;
use App\Orchid\Layouts\Material\MaterialTypeSelection;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class MaterialTypeListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'material_types' => MaterialType::filtersApplySelection(MaterialTypeSelection::class)
                ->filters()
                ->defaultSort('sort')
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
        return 'Типы материалов';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Link::make('Создать новый тип материала')->route('platform.material.type.create')];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [MaterialTypeSelection::class, MaterialTypeListLayout::class];
    }
}
