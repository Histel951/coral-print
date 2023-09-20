<?php

namespace App\Orchid\Screens\Preview;

use App\Models\Preview;
use App\Orchid\Layouts\Preview\PreviewListLayout;
use App\Orchid\Layouts\Preview\PreviewSelection;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class PreviewListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'previews' => Preview::filters()
                ->with(['calculator', 'calculatorType', 'cutting', 'form'])
                ->filtersApplySelection(PreviewSelection::class)
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
        return 'Превью';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Link::make('Создать')->route('platform.preview.create')];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [PreviewSelection::class, PreviewListLayout::class];
    }
}
