<?php

namespace App\Orchid\Screens\Design;

use App\Models\DesignCategory;
use App\Orchid\Layouts\Design\DesignCategoryListLayout;
use App\Orchid\Layouts\Design\DesignCategorySelection;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class DesignCategoryListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'designPrices' => DesignCategory::filters()
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
        return 'Категории дизайна';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Link::make('Создать')->route('platform.design.category.create')];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [DesignCategorySelection::class, DesignCategoryListLayout::class];
    }
}
