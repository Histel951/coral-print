<?php

namespace App\Orchid\Layouts;

use App\Models\Tooltip;
use App\Orchid\Custom\CustomTable;
use App\Orchid\Custom\CustomTD;
use App\Services\Calculator\TooltipFieldsService;
use App\Services\TooltipService;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;

class TooltipTable extends CustomTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'table';
    protected $customTDView = 'partials.orchid.tooltip_td';

    /**
     * @param TooltipService $tooltipService
     * @param TooltipFieldsService $tooltipFieldsService
     */
    public function __construct(
        private readonly TooltipService $tooltipService,
        private readonly TooltipFieldsService $tooltipFieldsService,
    ) {
    }

    /**
     * Get the table cells to be displayed.
     *
     * @return CustomTD[]
     */
    protected function columns(): iterable
    {
        return [
            CustomTD::make('id', 'ID')->render(function (Tooltip $model) {
                return $model->id;
            }),
            CustomTD::make('name', 'Название')->render(function (Tooltip $model) {
                return $model->name;
            }),
            CustomTD::make('type', 'Тип')->render(function (Tooltip $model) {
                return $this->tooltipService->getTypeText($model->type);
            }),
            CustomTD::make('calculator_type_id', 'Тип калькулятора')
                ->sort()
                ->render(function (Tooltip $model) {
                    return $model->calculatorType->name;
                }),
            CustomTD::make('field_id', 'Поле')->render(function (Tooltip $model) {
                return $this->tooltipFieldsService->label($model);
            }),
            CustomTD::make('is_active', 'Активна')->render(function (Tooltip $model) {
                return $model->is_active ? 'Да' : 'Нет';
            }),
            CustomTD::make('action', 'Действие')->render(function (Tooltip $model) {
                return Group::make([Link::make('Редактировать')->route('platform.tooltip.edit', $model)]);
            }),
        ];
    }
}
