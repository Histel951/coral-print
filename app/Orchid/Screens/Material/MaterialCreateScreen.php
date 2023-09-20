<?php

namespace App\Orchid\Screens\Material;

use App\Events\MaterialCacheClearEvent;
use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\MaterialType;
use App\Models\PrintSpecie;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class MaterialCreateScreen extends Screen
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
        return 'Создание нового материала';
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
                        ->required()
                        ->placeholder('Название..'),

                    Input::make('type_name')
                        ->title('Название типа')
                        ->placeholder('Название типа..'),

                    TextArea::make('desc')->title('Описание'),

                    Input::make('article')
                        ->placeholder('H881 62xps 517 / Itraco')
                        ->title('Артикул'),

                    Input::make('min_meters')
                        ->placeholder('500')
                        ->title('Мин. метров')
                        ->type('number'),

                    Select::make('print_specie_id')
                        ->title('Разновидость печати')
                        ->fromModel(PrintSpecie::class, 'name'),

                    Input::make('sequence')
                        ->placeholder('2')
                        ->title('Последовательность')
                        ->type('number'),

                    Input::make('width')
                        ->placeholder('215')
                        ->title('Ширина')
                        ->type('number'),

                    Input::make('weight')
                        ->placeholder('80')
                        ->title('Вес')
                        ->type('number'),

                    CheckBox::make('is_hex')
                        ->sendTrueOrFalse()
                        ->title('Hex'),

                    Select::make('material_type_id')
                        ->title('Тип материала')
                        ->fromModel(MaterialType::class, 'type_name'),

                    Select::make('material_category_id')
                        ->title('Категория материала')
                        ->fromModel(MaterialCategory::class, 'name'),

                    Input::make('volume')
                        ->title('Объём')
                        ->placeholder('134')
                        ->type('number'),

                    CheckBox::make('is_show')
                        ->sendTrueOrFalse()
                        ->title('Показывать'),
                ]),
            ]),
        ];
    }

    /**
     * Сохраняет новый материал
     * @param Request $request
     * @param Material $material
     * @return void
     */
    public function create(Request $request, Material $material): void
    {
        if ($material->fill($request->all())->save()) {
            event(new MaterialCacheClearEvent());
            Alert::success('Материал успешно создан!');
        } else {
            Alert::warning('Материал не создан');
        }
    }
}
