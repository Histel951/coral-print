<?php

namespace App\Orchid\Screens\Print\Type;

use App\Models\PrintSpecie;
use App\Models\PrintType;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PrintTypeCreateScreen extends Screen
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
        return 'Создать тип печати';
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
                    Input::make('printType.name')
                        ->title('Название')
                        ->placeholder('Тип печати..')
                        ->required(),

                    Input::make('printType.volume')
                        ->title('Объём')
                        ->placeholder('0.501')
                        ->type('number')
                        ->step('0.001')
                        ->required(),

                    Input::make('printType.sequence')
                        ->title('Порядок')
                        ->placeholder('1')
                        ->value(1)
                        ->type('number'),

                    Select::make('printType.print_type_id')
                        ->title('Тип печати')
                        ->fromModel(PrintType::class, 'name', 'id')
                        ->empty('Не выбрано', 0),
                ]),
            ]),
        ];
    }

    public function save(PrintSpecie $printType, Request $request): void
    {
        if ($printType->fill($request->get('printType'))->save()) {
            Alert::success('Тип печати успешно создана.');
        } else {
            Alert::warning('Тип печати не создана.');
        }
    }
}
