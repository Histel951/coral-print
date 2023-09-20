<?php

namespace App\Orchid\Screens\Material;

use App\Models\MaterialType;
use App\Orchid\Screens\EditScreen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class MaterialTypeEditScreen extends EditScreen
{
    /**
     * @var MaterialType
     */
    public MaterialType $materialType;

    /**
     * @var Collection
     */
    public Collection $materials;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(MaterialType $materialType): iterable
    {
        return [
            'materialType' => $materialType,
            'materials' => $materialType->materials,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Редактирование типа материала \"{$this->materialType->type_name}\" [{$this->materialType->id}]";
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::tabs([
                'Тип материалов' => [
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
                ],
            ]),
        ];
    }

    public function edit(MaterialType $materialType, Request $request): void
    {
        if ($materialType->fill($request->get('materialType'))->save()) {
            Alert::success('Тип материала успешно обновлён');
        } else {
            Alert::warning('Тип материала не обновлён.');
        }
    }

    public function delete(MaterialType $materialType): RedirectResponse
    {
        $materialType->delete();

        return redirect()->route('platform.material.types');
    }
}
