<?php

namespace App\Orchid\Screens;

use App\Models\Order;
use App\Orchid\Helpers\HAlert;
use App\Orchid\Layouts\OrderTable;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;

class OrderScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'table' => Order::filters()
                ->defaultSort('created_at', 'desc')
                ->paginate(10),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Заказы';
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
        return [OrderTable::class];
    }

    public function changeStatus(Request $request)
    {
        $model = Order::find($request->get('id'));
        $model->status = $request->get('newStatus');
        $success = $model->save();

        HAlert::alert($success);
    }
}
