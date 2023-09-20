<?php

namespace App\Orchid\Screens\Work;

use App\Models\WorkAdditional;
use App\Orchid\Layouts\Work\WorkAdditionalListLayout;
use App\Orchid\Layouts\Work\WorkAdditionalSelection;
use App\Orchid\Module\Print\BreadCrumbsCookie;
use App\Orchid\Module\Print\PrintBreadCrumbs;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class WorkAdditionalListScreen extends Screen
{
    private int $workAdditionalTypeId;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Request $request): iterable
    {
        return [
            'additionalWorks' => WorkAdditional::with(['formula', 'type'])
                ->filtersApplySelection(WorkAdditionalSelection::class)
                ->filters()
                ->defaultSort('id')
                ->paginate(),
            'workAdditionalTypeId' => (int) $request->get('work_additional_type_id'),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Доп. работы';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Создать')->route('platform.works.additional.create', [
                'work_additional_type_id' => \request('work_additional_type_id'),
            ]),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        PrintBreadCrumbs::set(BreadCrumbsCookie::WorkAdditionalPrint);

        return [WorkAdditionalSelection::class, WorkAdditionalListLayout::class];
    }
}
