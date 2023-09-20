<?php

namespace App\Orchid\Screens\PrintModule;

use App\Models\WorkAdditional;
use App\Orchid\Layouts\PrintModule\WorkAdditionalListLayout;
use App\Orchid\Layouts\Work\WorkAdditionalSelection;
use Orchid\Screen\Screen;

class WorkAdditionalListScreen extends Screen
{
    public WorkAdditional $additionalWorks;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'additionalWorks' => WorkAdditional::with(['formula', 'type'])
                ->filtersApplySelection(WorkAdditionalSelection::class)
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
        return $this->additionalWorks->type->name;
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
        return [WorkAdditionalListLayout::class];
    }
}
