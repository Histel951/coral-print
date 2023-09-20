<?php

namespace App\Orchid\Screens\Work;

use App\Models\WorkAdditionalType;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class WorkAdditionalTypeCreateScreen extends Screen
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
        return 'Создание типа доп работы';
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
                    Input::make('workAdditionalType.name')
                        ->title('Название')
                        ->placeholder('Ламинация..'),
                ]),
            ]),
        ];
    }

    public function save(WorkAdditionalType $workAdditionalType, Request $request): void
    {
        if ($workAdditionalType->fill($request->get('workAdditionalType'))->save()) {
            Alert::success('Тип доп. работы успешно создан!');
        } else {
            Alert::warning('Тип доп. работы не создан.');
        }
    }
}
