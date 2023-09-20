<?php

namespace App\Orchid\Screens\Material;

use App\Models\MaterialType;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class MaterialTypeCreateScreen extends Screen
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
        return 'Создание нового типа материала';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Button::make('Сохранить')->method('create')];
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
                    Input::make('materialType.name')
                        ->title('Название')
                        ->placeholder('Название')
                        ->required(),

                    Input::make('materialType.type_name')
                        ->title('Название типа')
                        ->placeholder('Название')
                        ->required(),

                    Input::make('materialType.sort')
                        ->title('Сортировка')
                        ->type('number'),
                ]),
            ]),
        ];
    }

    public function create(MaterialType $materialType, Request $request)
    {
        if ($materialType->fill($request->get('materialType'))->save()) {
            Alert::success('Тип материала успешно обновлён');
        } else {
            Alert::warning('Тип материала не обновлён.');
        }
    }
}
