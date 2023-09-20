<?php

namespace App\Orchid\Screens\Material;

use App\Events\MaterialCacheClearEvent;
use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\PrintSpecie;
use App\Orchid\Fields\ClearPicture;
use App\Orchid\Fields\ColorInput;
use App\Orchid\Layouts\MaterialPriceListener;
use App\Orchid\Module\Print\BreadCrumbsCookie;
use App\Orchid\Screens\EditScreen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class MaterialEditScreen extends EditScreen
{
    /**
     * @var Material
     */
    public Material $material;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Material $material): iterable
    {
        return [
            'material' => $material,
            'colors' => $material->materialSubTypes,
            'price' => $material->price,
            'cost_price' => $material->cost_price,
            'price_percent' => $material->price_percent,
            'material_id' => $material->id,
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Link::back(BreadCrumbsCookie::MaterialPrint, 'platform.module.print.materials', [
                'filter[print_specie_id]' => $this->material->print_specie_id,
            ]),
            ...parent::commandBar(),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Редактирование материала \"{$this->material->name}\" [{$this->material->id}]";
    }

    public function description(): ?string
    {
        return $this->material->desc ?? '';
    }

    public function asyncPrice(int $pricePercent, float $costPrice, float $price = null, int $materialId = null): array
    {
        $price = $costPrice + $costPrice * ($pricePercent / 100);

        Material::query()
            ->find($materialId)
            ->update([
                'price_percent' => $pricePercent,
                'price' => $price,
                'cost_price' => $costPrice,
            ]);

        return [
            'cost_price' => $costPrice,
            'material_id' => $materialId,
            'price_percent' => $pricePercent,
            'price' => $price,
            'material.cost_price' => $costPrice,
            'material.price_percent' => $pricePercent,
            'material.price' => $price,
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
            Layout::tabs([
                'Параметры' => [
                    MaterialPriceListener::class,
                    Layout::rows([
                        Input::make('material.name')
                            ->title('Название')
                            ->required()
                            ->placeholder('Название..'),

                        Input::make('material.type_name')
                            ->title('Название типа')
                            ->placeholder('Название типа..'),

                        Select::make('material.material_category_id')
                            ->title('Категория')
                            ->fromModel(MaterialCategory::class, 'name'),

                        TextArea::make('material.desc')->title('Описание'),

                        Input::make('material.weight')
                            ->placeholder('80')
                            ->title('Плотность (г/м2)')
                            ->type('number')
                            ->value(0)
                            ->required(),

                        Input::make('material.volume')
                            ->title('Толщина (микрон)')
                            ->placeholder('134')
                            ->type('number'),

                        Input::make('material.sequence')
                            ->placeholder('2')
                            ->title('Порядок')
                            ->type('number')
                            ->value(1)
                            ->required(),

                        CheckBox::make('material.is_show')
                            ->sendTrueOrFalse()
                            ->title('Показывать'),

                        CheckBox::make('material.is_hex')
                            ->sendTrueOrFalse()
                            ->title('Хекс цвет'),

                        Select::make('material.print_specie_id')
                            ->title('Разновидость печати')
                            ->fromModel(PrintSpecie::class, 'name'),
                    ]),
                ],
                'Цвета' => [
                    Layout::rows([
                        Matrix::make('colors')
                            ->title('Цвета')
                            ->columns([
                                'Название' => 'name',
                                'Цвет' => 'color',
                                'Порядок' => 'sequence',
                                'Превью' => 'image_id',
                            ])
                            ->fields([
                                'name' => Input::make(),
                                'color' => ColorInput::make()->type('text'),
                                'sequence' => Input::make()->type('number'),
                                'image_id' => ClearPicture::make()->targetId(),
                            ]),
                    ]),
                ],
            ]),
        ];
    }

    public function edit(Material $material, Request $request)
    {
        if (
            $material
                ->fill(
                    Arr::collapse([
                        $request->get('material'),
                        [
                            'price' => $request->get('price'),
                            'cost_price' => $request->get('cost_price'),
                            'price_percent' => $request->get('price_percent'),
                        ],
                    ]),
                )
                ->save()
        ) {
            $material->materialSubTypes()->delete();

            if ($request->get('colors')) {
                foreach ($request->get('colors') as $color) {
                    $material->materialSubTypes()->create($color);
                }
            }

            event(new MaterialCacheClearEvent());
            Alert::success('Материал успешно обновлён!');
        } else {
            Alert::warning('Материал не обновлён!');
        }
    }

    public function delete(Material $material): RedirectResponse
    {
        $material->delete();
        event(new MaterialCacheClearEvent());

        return redirect()->route('platform.materials', [
            'filter[print_specie_id]' => $material->print_specie_id,
        ]);
    }
}
