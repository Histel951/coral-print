<?php

namespace App\Orchid\Screens;

use App\Models\Call;
use App\Orchid\Helpers\HAlert;
use App\Orchid\Layouts\CallTable;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;

class CallScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'table' => Call::filters()
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
        return 'Звонки';
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
        return [CallTable::class];
    }

    public function changeStatus(Request $request)
    {
        $model = Call::find($request->get('id'));
        $model->status = $request->get('newStatus');
        $success = $model->save();

        HAlert::alert($success);
    }
}
