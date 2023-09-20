<?php

namespace App\Orchid\Screens\Material;

use App\Models\Material;
use App\Models\MaterialSubType;
use App\Orchid\Screens\EditScreen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class MaterialSubTypesEditScreen extends EditScreen
{
    public MaterialSubType $materialSubType;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(MaterialSubType $materialSubType): iterable
    {
        return [
            'materialSubType' => $materialSubType,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Редактирование подтипа материала \"{$this->materialSubType->name}\" [{$this->materialSubType->id}]";
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
                    Input::make('materialSubType.name')
                        ->title('Название')
                        ->placeholder('Название..')
                        ->required(),

                    Input::make('materialSubType.cost_price')
                        ->title('Себестоимость')
                        ->placeholder('0.3')
                        ->step('0.01')
                        ->type('number'),

                    Input::make('materialSubType.extra_change')
                        ->placeholder('100')
                        ->type('number'),

                    Input::make('materialSubType.price')
                        ->placeholder('0.6')
                        ->type('number')
                        ->step('0.01'),

                    Picture::make('materialSubType.image_id')
                        ->title('Изображение')
                        ->targetId(),

                    Input::make('materialSubType.sequence')
                        ->title('Последовательность')
                        ->type('number'),

                    Select::make('materialSubType.material_id')
                        ->title('Материал')
                        ->fromModel(Material::class, 'name', 'id'),

                    Input::make('materialSubType.color')
                        ->title('Материал')
                        ->type('color'),

                    CheckBox::make('materialSubType.hex')
                        ->title('Хекс цвет')
                        ->sendTrueOrFalse(),
                ]),
            ]),
        ];
    }

    public function edit(MaterialSubType $materialSubType, Request $request)
    {
        if ($materialSubType->fill($request->get('materialSubType'))->save()) {
            Alert::success('Подкатегория материала успешно обновлена!');
        } else {
            Alert::warning('Подкатегория материала не обновлена!');
        }
    }

    public function delete(MaterialSubType $materialSubType): RedirectResponse
    {
        $materialSubType->delete();

        return redirect()->route('platform.material.sub.types');
    }
}
