<?php

namespace App\Orchid\Screens\Design;

use App\Models\DesignSubcategory;
use App\Orchid\Layouts\Design\DesignSubcategoryListLayout;
use App\Orchid\Layouts\Design\DesignSubcategorySelection;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class DesignSubcategoryListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'designSubcategories' => DesignSubcategory::with(['category'])
                ->filtersApplySelection(DesignSubcategorySelection::class)
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
        return 'Подкатегории дизайна';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Link::make('Создать')->route('platform.design.subcategory.create')];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [DesignSubcategorySelection::class, DesignSubcategoryListLayout::class];
    }
}
