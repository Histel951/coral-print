<?php

namespace App\Orchid\Screens\Material;

use App\Models\MaterialCategory;
use App\Orchid\Layouts\Material\MaterialCategoryListLayout;
use App\Orchid\Layouts\Material\MaterialCategorySelection;
use Orchid\Screen\Screen;

class MaterialCategoryListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'materialCategory' => MaterialCategory::filtersApplySelection(MaterialCategorySelection::class)
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
        return 'Категории материалов';
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
        return [MaterialCategorySelection::class, MaterialCategoryListLayout::class];
    }
}
