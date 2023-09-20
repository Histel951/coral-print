<?php

namespace App\Orchid\Screens;

use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\PrintSpecie;
use App\Orchid\Layouts\MaterialPriceListener;
use App\Orchid\Module\Print\BreadCrumbsCookie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PrintTypeMaterialCreateScreen extends Screen
{
    public PrintSpecie $printSpecie;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Request $request): iterable
    {
        $printSpecie = PrintSpecie::find($request->get('specieType'));

        return [
            'printSpecie' => $printSpecie,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Создание материала для \"{$this->printSpecie->name}\"";
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::back(BreadCrumbsCookie::MaterialPrint, 'platform.module.print.materials', [
                'filter[print_specie_id]' => \request('specieType'),
            ]),
            Button::make('Сохранить')->method('create'),
        ];
    }

    public function asyncPrice(int $pricePercent, float $costPrice, float $price = null): array
    {
        return [
            'cost_price' => $costPrice,
            'price_percent' => $pricePercent,
            'price' => $costPrice + $costPrice * ($pricePercent / 100),
            'material.cost_price' => $costPrice,
            'material.price_percent' => $pricePercent,
            'material.price' => $costPrice + $costPrice * ($pricePercent / 100),
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
            MaterialPriceListener::class,
            Layout::columns([
                Layout::rows([
                    Input::make('material.name')
                        ->title('Название')
                        ->required()
                        ->placeholder('Название..'),

                    Select::make('material.material_category_id')
                        ->title('Категория')
                        ->fromModel(MaterialCategory::class, 'name'),

                    TextArea::make('material.desc')->title('Описание'),

                    Input::make('printSpecie.name')
                        ->title('Разновидость печати')
                        ->readonly(),

                    Input::make('printSpecie.id')->hidden(),

                    Input::make('material.weight')
                        ->placeholder('80')
                        ->title('Плотность (г/м2)')
                        ->required()
                        ->value(0)
                        ->type('number'),

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
                        ->value(true)
                        ->title('Показывать'),

                    CheckBox::make('material.is_hex')
                        ->sendTrueOrFalse()
                        ->title('Хекс цвет'),
                ]),
            ]),
        ];
    }

    /**
     * Сохраняет новый материал
     * @param Request $request
     * @param Material $material
     * @return RedirectResponse
     */
    public function create(Request $request, Material $material): RedirectResponse
    {
        if (
            $material
                ->fill(
                    Arr::collapse([
                        [
                            'cost_price' => $request->get('cost_price'),
                            'price' => $request->get('price'),
                            'price_percent' => $request->get('price_percent'),
                            'type_name' => transliterate($request->get('material')['name'] ?? ''),
                            'print_specie_id' => $request->get('printSpecie')['id'] ?? null,
                        ],
                        $request->get('material'),
                    ]),
                )
                ->save()
        ) {
            Alert::success('Материал успешно создан!');

            return redirect()->route('platform.print.material.edit', ['material' => $material]);
        } else {
            Alert::warning('Материал не создан');
        }
    }
}
