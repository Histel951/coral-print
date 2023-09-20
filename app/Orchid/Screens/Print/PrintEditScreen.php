<?php

namespace App\Orchid\Screens\Print;

use App\Models\PrintModel;
use App\Models\PrintType;
use App\Orchid\Screens\EditScreen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PrintEditScreen extends EditScreen
{
    public PrintModel $print;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(PrintModel $print): iterable
    {
        return [
            'print' => $print,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Редактирование печати \"{$this->print->name}\" [{$this->print->id}]";
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::columns([
                Layout::rows([
                    Input::make('print.name')
                        ->title('Название')
                        ->placeholder('Название..'),

                    Select::make('print.print_type_id')->fromModel(PrintType::class, 'name', 'id'),
                ]),
            ]),
        ];
    }

    public function edit(PrintModel $print, Request $request)
    {
        if ($print->fill($request->get('print'))->save()) {
            Alert::success('Печать успешно обновлена!');
        } else {
            Alert::warning('Печать не обновлена.');
        }
    }

    public function delete(PrintModel $print): RedirectResponse
    {
        $print->delete();

        return redirect()->route('platform.prints');
    }
}
