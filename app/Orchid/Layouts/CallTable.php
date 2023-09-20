<?php

namespace App\Orchid\Layouts;

use App\Models\Call;
use App\Orchid\Custom\CustomTable;
use App\Orchid\Custom\CustomTD;
use App\Services\CallService;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;

class CallTable extends CustomTable
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

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */

    protected $customTDView = 'partials.orchid.call_td';

    protected CallService $callService;

    /**
     * @param CallService $callService
     */
    public function __construct(CallService $callService)
    {
        $this->callService = $callService;
    }

    protected function columns(): iterable
    {
        $cols = [
            CustomTD::make('id', 'ID')->render(function (Call $model) {
                return $model->id;
            }),
            CustomTD::make('created_at', 'Дата')->render(function (Call $model) {
                return $model->created_at;
            }),
            CustomTD::make('phone', 'Телефон')->render(function (Call $model) {
                return Link::make($model->phone)
                    ->href('tel:' . $model->phone)
                    ->target('_blank');
            }),
            CustomTD::make('status', 'Статус')->render(function (Call $model) {
                return $this->callService->getStatusText($model->status);
            }),
            CustomTD::make('action', 'Действие')->render(function (Call $model) {
                return Button::make('Обработать')
                    ->hidden($model->status != CallService::STATUS_NEW)
                    ->method('changeStatus')
                    ->icon('note')
                    ->confirm('Вы уверены, что хотите пометить звонок обработанным?')
                    ->parameters(['id' => $model->id, 'newStatus' => CallService::STATUS_PROCESSED]);
            }),
        ];

        return $cols;
    }
}
