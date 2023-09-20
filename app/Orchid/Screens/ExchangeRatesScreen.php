<?php

namespace App\Orchid\Screens;

use App\Models\ExchangeRate;
use App\Orchid\Helpers\HAlert;
use Illuminate\Support\Facades\Cache;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Symfony\Component\HttpFoundation\Request;

class ExchangeRatesScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'table' => ExchangeRate::all(),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Курсы валют';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Создать')
                ->modal('asyncEditModal')
                ->modalTitle('Новая валюта')
                ->method('saveRate')
                ->icon('new-doc'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('table', [
                TD::make('id', 'ID')->render(function (ExchangeRate $model) {
                    return $model->id;
                }),

                TD::make('name', 'Название')->render(function (ExchangeRate $model) {
                    return $model->name;
                }),

                TD::make('value', 'Значение')->render(function (ExchangeRate $model) {
                    return $model->value;
                }),

                TD::make('action', 'Действие')->render(function (ExchangeRate $model) {
                    return Group::make([
                        ModalToggle::make('Редактировать')
                            ->modal('asyncEditModal')
                            ->modalTitle('Настройки валюты')
                            ->method('saveRate')
                            ->icon('note')
                            ->asyncParameters($model->toArray()),

                        ModalToggle::make('Удалить')
                            ->modal('asyncDeleteModal')
                            ->modalTitle('Удалить валюту')
                            ->method('deleteRate')
                            ->icon('cross')
                            ->asyncParameters(['id' => $model->id]),
                    ]);
                }),
            ]),

            Layout::modal('asyncEditModal', [
                Layout::rows([Input::make('name')->title('Название'), Input::make('value')->title('Значение')]),
            ])
                ->applyButton('OK')
                ->withoutCloseButton()
                ->async('asyncGetData'),

            Layout::modal('asyncDeleteModal', [
                Layout::rows([])->title('Вы уверены, что хотите безвозвратно удалить запись?'),
            ])
                ->applyButton('Да')
                ->closeButton('Нет')
                ->async('asyncGetData'),
        ];
    }
    public function asyncGetData(Request $request): array
    {
        return [
            'name' => $request->get('name'),
            'value' => $request->get('value'),
        ];
    }

    public function saveRate(Request $request): void
    {
        $request->validate([
            'name' => 'required|string',
            'value' => 'required|numeric|min:0',
        ]);

        if ($model = ExchangeRate::find($request->get('id'))) {
            $success = $model->update($request->all());
        } else {
            $success = ExchangeRate::create($request->all());
        }

        $this->clearCache();
        HAlert::alert($success);
    }

    public function deleteRate(Request $request): void
    {
        if ($model = ExchangeRate::find($request->get('id'))) {
            $success = $model->delete();
            $this->clearCache();
            HAlert::alert($success);
        }
    }

    private function clearCache(): void
    {
        Cache::tags(['calculator', 'flex', 'euro'])->clear();
    }
}
