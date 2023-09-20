<?php

namespace App\Orchid\Screens\Material;

use App\Models\Material;
use App\Models\MaterialSubType;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class MaterialSubTypesCreateScreen extends Screen
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
        return 'Создание нового подтипа материала';
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
                    Input::make('name')
                        ->title('Название')
                        ->placeholder('Название..')
                        ->required(),

                    Input::make('cost_price')
                        ->title('Себестоимость')
                        ->placeholder('0.3')
                        ->step('0.01')
                        ->type('number'),

                    Input::make('extra_change')
                        ->placeholder('100')
                        ->type('number'),

                    Input::make('price')
                        ->placeholder('0.6')
                        ->type('number')
                        ->step('0.01'),

                    Picture::make('image_id')
                        ->title('Изображение')
                        ->targetId(),

                    Input::make('sequence')
                        ->title('Последовательность')
                        ->type('number'),

                    Select::make('material_id')
                        ->title('Материал')
                        ->fromModel(Material::class, 'name', 'id'),

                    Input::make('color')
                        ->title('Материал')
                        ->type('color'),

                    CheckBox::make('hex')
                        ->title('Хекс цвет')
                        ->sendTrueOrFalse(),
                ]),
            ]),
        ];
    }

    public function create(Request $request, MaterialSubType $materialSubType)
    {
        if ($materialSubType->fill($request->all())->save()) {
            Alert::success('Подтип материала успешно создан!');
        } else {
            Alert::warning('Подтип материала не создан.');
        }
    }
}
