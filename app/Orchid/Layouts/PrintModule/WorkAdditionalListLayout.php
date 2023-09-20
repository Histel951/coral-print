<?php

namespace App\Orchid\Layouts\PrintModule;

use App\Models\WorkAdditional;
use App\Orchid\Custom\CustomTD;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\TD;

class WorkAdditionalListLayout extends StandardTable
{
    protected string $editRoute = 'platform.works.additional.edit';

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'additionalWorks';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('formula.name', 'Формула'),

            TD::make('name', 'Название'),
            TD::make('type_name', 'Название типа'),
            TD::make('color', 'Цвет')
                ->render(function (WorkAdditional $workAdditional) {
                    return "<div style='display: flex; justify-content: center' title='{$workAdditional->color}'>
                                    <div style='
                                        width: 20px;
                                        height: 20px;
                                        background-color: {$workAdditional->color};
                                        border: 1px solid #616161;
                                        border-radius: 50%;'>
                                    </div>
                                </div>";
                })
                ->alignCenter(),
            TD::make('code', 'Тэг'),
            TD::make('weight', 'Масса')->sort(),
            TD::make('volume', 'Объём')->sort(),
            TD::make('times', 'Повторения')->sort(),
            TD::make('type.name', 'Тип доп работы'),

            TD::make('action', 'Действие')->render(function (WorkAdditional $workAdditional) {
                return CustomTD::make()->optionButtons('platform.works.additional.edit', $workAdditional);
            }),
        ];
    }
}
