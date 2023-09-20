<?php

namespace App\Orchid\Screens\Work;

use App\Models\WorkAdditionalType;
use App\Orchid\Layouts\Work\WorkAdditionalTypeListLayout;
use App\Orchid\Layouts\Work\WorkAdditionalTypeSelection;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class WorkAdditionalTypeListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'workAdditionalTypes' => WorkAdditionalType::filtersApplySelection(WorkAdditionalTypeSelection::class)
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
        return 'Типы доп работ';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Link::make('Создать')->route('platform.works.additional.type.create')];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [WorkAdditionalTypeSelection::class, WorkAdditionalTypeListLayout::class];
    }
}
