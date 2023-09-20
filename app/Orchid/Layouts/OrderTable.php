<?php

namespace App\Orchid\Layouts;

use App\Models\Order;
use App\Orchid\Custom\CustomTable;
use App\Orchid\Custom\CustomTD;
use App\Services\OrderService;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\TD;

class OrderTable extends CustomTable
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

    protected $customTDView = 'partials.orchid.order_td';

    protected OrderService $orderService;

    /**
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    protected function columns(): iterable
    {
        $cols = [
            CustomTD::make('id', 'ID')
                ->render(function (Order $model) {
                    return $model->id;
                })
                ->sort(),
            CustomTD::make('created_at', 'Дата')
                ->render(function (Order $model) {
                    return $model->created_at;
                })
                ->sort(),
            CustomTD::make('name', 'Имя')
                ->render(function (Order $model) {
                    return $model->name;
                })
                ->filter(Input::make()),
            CustomTD::make('email', 'Email')
                ->render(function (Order $model) {
                    return Link::make($model->email)
                        ->href('mailto:' . $model->email)
                        ->target('_blank');
                })
                ->filter(Input::make()),
            CustomTD::make('message', 'Сообщение')
                ->width('auto')
                ->render(function (Order $model) {
                    return $model->message;
                })
                ->filter(Input::make()),
            CustomTD::make('attachments', 'Вложения')->render(function (Order $model) {
                return $model->attachments->count()
                    ? Link::make('Скачать')->href(route('order.download', ['id' => $model->id]))
                    : ''; //->target('_blank');
            }),
            CustomTD::make('status', 'Статус')
                ->render(function (Order $model) {
                    return $this->orderService->getStatusText($model->status);
                })
                ->sort(),
            CustomTD::make('action', 'Действие')->render(function (Order $model) {
                return Button::make('Обработать')
                    ->hidden($model->status != OrderService::STATUS_NEW)
                    ->method('changeStatus')
                    ->icon('note')
                    ->confirm('Вы уверены, что хотите пометить звонок обработанным?')
                    ->parameters(['id' => $model->id, 'newStatus' => OrderService::STATUS_PROCESSED]);
            }),
        ];

        return $cols;
    }
}
