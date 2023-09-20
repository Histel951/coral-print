<?php

namespace App\Orchid\Screens\Print;

use App\Models\PrintModel;
use App\Models\PrintType;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PrintCreateScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Создание печати';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Button::make('Сохранить')->method('save')];
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
                        ->placeholder('Двухсторонние..'),

                    Relation::make('print.print_type_id')
                        ->title('Тип печати')
                        ->fromModel(PrintType::class, 'name', 'id'),
                ]),
            ]),
        ];
    }

    public function save(PrintModel $print, Request $request): void
    {
        if ($print->fill($request->get('print'))->save()) {
            Alert::success('Печать успешно создана.');
        } else {
            Alert::warning('Печать не создана.');
        }
    }
}
