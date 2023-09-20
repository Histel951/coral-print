<?php

namespace App\Orchid\Screens\Work;

use App\Models\WorkAdditional;
use App\Models\WorkAdditionalPrice;
use App\Orchid\Screens\EditScreen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class WorkAdditionalPriceEditScreen extends EditScreen
{
    public WorkAdditionalPrice $workAdditionalPrice;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(WorkAdditionalPrice $workAdditionalPrice): iterable
    {
        return [
            'workAdditionalPrice' => $workAdditionalPrice,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Редактирование цены доп. работы \"{}\" [{$this->workAdditionalPrice->id}]";
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

                    Input::make('workAdditionalPrice.change')
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

    public function delete(WorkAdditionalPrice $workAdditionalPrice): RedirectResponse
    {
        $workAdditionalPrice->delete();

        return redirect()->route('platform.works.additional.prices');
    }

    public function edit(WorkAdditionalPrice $workAdditionalPrice, Request $request): void
    {
        if ($workAdditionalPrice->fill($request->get('workAdditionalPrice'))->save()) {
            Alert::success('Цена доп. работы успешно обновлена!');
        } else {
            Alert::warning('Цена доп. работа не обновлена.');
        }
    }
}
