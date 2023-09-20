<?php

namespace App\Orchid\Layouts\Work;

use App\Models\WorkAdditionalType;
use App\Orchid\Custom\CustomTD;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;

class WorkAdditionalTypeListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'workAdditionalTypes';

    protected string $editRoute = 'platform.works.additional.type.edit';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('name', 'Название'),

            TD::make('prints', 'Доп. работы')
                ->alignCenter()
                ->width(30)
                ->render(
                    fn (WorkAdditionalType $workAdditionalType) => Link::make('перейти')
                        ->icon('arrow-right')
                        ->route('platform.print.works.additionals', [
                            'filter[work_additional_type_id]' => $workAdditionalType->id,
                            'work_additional_type_id' => $workAdditionalType->id,
                        ]),
                ),

            TD::make('action', 'Действие')->render(function (WorkAdditionalType $workAdditionalType) {
                return CustomTD::make()->optionButtons('platform.works.additional.type.edit', $workAdditionalType);
            }),
        ];
    }
}
