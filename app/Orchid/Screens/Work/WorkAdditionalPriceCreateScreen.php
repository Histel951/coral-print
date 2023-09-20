<?php

namespace App\Orchid\Screens\Work;

use App\Models\WorkAdditional;
use App\Models\WorkAdditionalPrice;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class WorkAdditionalPriceCreateScreen extends Screen
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
        return 'Создать цену на доп. работу';
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
                    Input::make('workAdditionalPrice.list_meters')
                        ->title('Длина листа (???)')
                        ->type('number')
                        ->placeholder('0'),

                    Input::make('workAdditionalPrice.circulation')
                        ->title('Обращение')
                        ->type('number')
                        ->placeholder('24'),

                    Input::make('workAdditionalPrice.price')
                        ->title('Цена')
                        ->type('number')
                        ->placeholder('234'),

                    Input::make('workAdditionalPrice.fixed_sum')
                        ->title('Фиксированная сумма')
                        ->type('number')
                        ->placeholder('50'),

                    Input::make('workAdditionalPrice.percent')
                        ->title('Процент')
                        ->type('number')
                        ->placeholder('10'),

                    Input::make('workAdditionalPrice.charge')
                        ->type('number')
                        ->placeholder('100'),

                    Relation::make('workAdditionalPrice.work_additional_id')
                        ->title('Доп. работа')
                        ->required()
                        ->fromModel(WorkAdditional::class, 'name', 'id'),
                ]),
            ]),
        ];
    }

    public function save(WorkAdditionalPrice $workAdditionalPrice, Request $request): void
    {
        if ($workAdditionalPrice->fill($request->get('workAdditionalPrice'))->save()) {
            Alert::success('Цена доп. работы успешно создана!');
        } else {
            Alert::warning('Цена доп. работа не создана.');
        }
    }
}
