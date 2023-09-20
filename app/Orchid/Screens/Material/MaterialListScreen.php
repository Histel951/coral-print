<?php

namespace App\Orchid\Screens\Material;

use App\Models\Material;
use App\Orchid\Layouts\Material\MaterialListLayout;
use App\Orchid\Layouts\Material\MaterialSelection;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class MaterialListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'materials' => Material::with(['type', 'category', 'printSpecie'])
                ->filtersApplySelection(MaterialSelection::class)
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
        return 'Список материалов';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Link::make('Создать материал')->route('platform.material.create')];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [MaterialSelection::class, MaterialListLayout::class];
    }
}
