<?php

namespace App\Orchid\Screens\PrintModule;

use App\Models\Color;
use App\Models\ColorCategory;
use App\Models\ColorPaint;
use App\Models\ColorPaintCategory;
use App\Models\Material;
use App\Models\MaterialType;
use App\Models\Rapport;
use App\Orchid\Helpers\HAlert;
use App\Orchid\Layouts\ColorPaintSelection;
use App\Orchid\Layouts\Flex\Color\ColorPaintLayout;
use App\Orchid\Layouts\Flex\ColorLayout;
use App\Orchid\Layouts\Flex\FlexMaterialListLayout;
use App\Orchid\Layouts\Flex\FlexMaterialSelection;
use App\Orchid\Layouts\Flex\Rapport\RapportLayout;
use App\Services\CustomConfigs;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class FlexScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function query(): iterable
    {
        $customConfigs = app()->make(CustomConfigs::class);

        return [
            'custom_config.euro_rate' => $customConfigs->get('euro_rate'),
            'custom_config.fitting_meters' => $customConfigs->get('fitting_meters'),
            'custom_config.min_fitting_meters_price' => $customConfigs->get('min_fitting_meters_price'),
            'custom_config.min_order_price' => $customConfigs->get('min_order_price'),
            'custom_config.pantone_displacement' => $customConfigs->get('pantone_displacement'),
            'custom_config.fix_euro_price' => $customConfigs->get('fix_euro_price'),
            'custom_config.form_markup_percent' => $customConfigs->get('form_markup_percent'),
            'custom_config.bushing_price' => $customConfigs->get('bushing_price'),
            'custom_config.markup_bushing_price_percent' => $customConfigs->get('markup_bushing_price_percent'),
            'custom_config.thermo_adjustment_cost' => $customConfigs->get('thermo_adjustment_cost'),
            'custom_config.thermo_adjustment_price' => $customConfigs->get('thermo_adjustment_price'),
            'colors' => ColorCategory::query()
                ->where('type', 'flex')
                ->first()
                ->colors()
                ->filters()
                ->paginate(),
            'paints' => ColorPaintCategory::query()
                ->where('type', 'flex')
                ->first()
                ->paints()
                ->filtersApplySelection(ColorPaintSelection::class)
                ->filters()
                ->paginate(),
            'materials' => MaterialType::where('name', 'flex')
                ->first()
                ->materials()
                ->with(['variety'])
                ->filtersApplySelection(FlexMaterialSelection::class)
                ->filters()
                ->defaultSort('sequence')
                ->paginate(20),
            'rapports' => Rapport::all(),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Флекса';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::modal('confirmDeleteMaterial', [
                Layout::rows([])->title('Вы действительно хотите удалить материал?')
            ])->applyButton('Да')->closeButton('Нет'),

            Layout::modal('confirmDeleteColor', [
                Layout::rows([])->title('Вы действительно хотите удалить цвет?')
            ])->applyButton('Да')->closeButton('Нет'),

            Layout::modal('confirmDeleteColorPaint', [
                Layout::rows([])->title('Вы действительно хотите удалить цвет?')
            ])->applyButton('Да')->closeButton('Нет'),

            Layout::modal('confirmDeleteRapport', [
                Layout::rows([])->title('Вы действительно хотите удалить раппорт?')
            ])->applyButton('Да')->closeButton('Нет'),

            Layout::columns([
                Layout::tabs([
                    'Настройки' => [
                        Layout::rows([
                            Input::make('custom_config.euro_rate')
                                ->title('Курс Евро')
                                ->placeholder('65')
                                ->type('number')
                                ->min(0)
                                ->step('0.01'),

                            Input::make('custom_config.fitting_meters')
                                ->title('Приладка (метры)')
                                ->min(0)
                                ->placeholder('70')
                                ->type('number'),

                            Input::make('custom_config.min_fitting_meters_price')
                                ->title('Минимальная стоимость приладки (руб)')
                                ->min(0)
                                ->placeholder('1500')
                                ->type('number'),

                            Input::make('custom_config.min_order_price')
                                ->title('Минимальная цена заказа')
                                ->min(0)
                                ->placeholder('1500')
                                ->type('number'),

                            Input::make('custom_config.pantone_displacement')
                                ->title('Литраж пантона')
                                ->min(0)
                                ->placeholder('1')
                                ->type('number'),
                        ]),
                        Layout::rows([
                            Input::make('custom_config.fix_euro_price')
                                ->title('Фиксированная стоимость (евро)')
                                ->step('0.01')
                                ->placeholder('0.30')
                                ->type('number')
                                ->min(0),

                            Input::make('custom_config.form_markup_percent')
                                ->title('Наценка на формы (%)')
                                ->placeholder('20')
                                ->type('number')
                                ->min(0),
                        ]),
                        Layout::rows([
                            Input::make('custom_config.bushing_price')
                                ->title('Цена втулки')
                                ->placeholder('0.06')
                                ->type('number')
                                ->min(0)
                                ->step('0.01'),

                            Input::make('custom_config.markup_bushing_price_percent')
                                ->title('Наценка на втулки %')
                                ->placeholder('0.06')
                                ->type('number')
                                ->min(0)
                                ->step('0.01'),
                        ]),
                        Layout::rows([
                            Input::make('custom_config.thermo_adjustment_cost')
                                ->title('Термо приладка себестоимость руб')
                                ->placeholder('0.06')
                                ->type('number')
                                ->min(0)
                                ->step('0.01'),

                            Input::make('custom_config.thermo_adjustment_price')
                                ->title('Термо приладка руб')
                                ->placeholder('0.06')
                                ->type('number')
                                ->min(0)
                                ->step('0.01'),
                        ]),
                    ],
                    'Материалы' => [FlexMaterialSelection::class, FlexMaterialListLayout::class],
                    'Краски' => [ColorPaintSelection::class, ColorPaintLayout::class],
                    'Раппорты' => [RapportLayout::class],
                    'Цвета' => [ColorLayout::class],
                ]),
            ]),
        ];
    }

    public function addMaterial(): Response
    {
        $layout = new FlexMaterialListLayout();
        $newMaterial = Material::create([
            'type' => 1,
            'name' => 'default name',
            'article' => 'article',
            'price' => 1,
            'price_percent' => 100,
            'material_type_id' => MaterialType::where('name', 'flex')->first()->id,
            'sequence' => Material::query()->count() + 1,
            'min_meters' => 0,
        ]);

        $material = Material::find($newMaterial->getKey());

        return \response()->view(
            'orchid.turbo.turbo-stream-tr-item-add',
            [
                'source' => $material,
                'columns' => $layout->getColumns(),
                'target' => 'table-tbody-flex-material',
                'trItemId' => "tr-item-flex-material-$material->id",
            ],
            headers: [
                'Content-Type' => 'text/vnd.turbo-stream.html',
            ],
        );
    }

    public function changeColorField(Request $request): Response
    {
        return $this->changeFieldsResponse(Color::class, $request->get('id'), [
            $request->input('field') => $request->input('content'),
        ]);
    }

    public function addColor(): Response
    {
        $layout = new ColorLayout();
        $newColor = Color::create([
            'name' => 'default name',
        ]);

        $color = Color::find($newColor->getKey());
        ColorCategory::where('type', 'flex')
            ->first()
            ->colors()
            ->attach($color->id);

        return \response()->view(
            'orchid.turbo.turbo-stream-tr-item-add',
            [
                'source' => $color,
                'columns' => $layout->getColumns(),
                'target' => 'table-tbody-colors',
                'trItemId' => "tr-item-color-$color->id",
            ],
            headers: [
                'Content-Type' => 'text/vnd.turbo-stream.html',
            ],
        );
    }

    public function changeColorPaintPicture(Request $request): Response
    {
        return $this->changeFieldsResponse(ColorPaint::class, $request->get('id'), [
            $request->input('field') => $request->input('content'),
        ]);
    }

    public function changeColorPaintField(Request $request): Response
    {
        return $this->changeFieldsResponse(ColorPaint::class, $request->get('id'), [
            $request->input('field') => $request->input('content'),
        ]);
    }

    public function addNewRapport(): Response
    {
        $layout = new RapportLayout();
        $newRapport = Rapport::create([
            'name' => 'default name',
        ]);

        $rapport = Rapport::find($newRapport->getKey());

        return \response()->view(
            'orchid.turbo.turbo-stream-tr-item-add',
            [
                'source' => $rapport,
                'columns' => $layout->getColumns(),
                'target' => 'table-tbody-rapport',
                'trItemId' => "tr-item-rapport-$rapport->id",
            ],
            headers: [
                'Content-Type' => 'text/vnd.turbo-stream.html',
            ],
        );
    }

    public function addNewColorPaint(): Response
    {
        $layout = new ColorPaintLayout();
        $newColorPaint = ColorPaint::create([
            'name' => 'default name',
            'consumption' => 0.002,
            'price' => 0,
            'price_percent' => 70,
        ]);

        $colorPaint = ColorPaint::find($newColorPaint->getKey());
        ColorPaintCategory::where('type', 'flex')
            ->first()
            ->paints()
            ->attach($colorPaint->id);

        return \response()->view(
            'orchid.turbo.turbo-stream-tr-item-add',
            [
                'source' => $colorPaint,
                'columns' => $layout->getColumns(),
                'target' => 'table-tbody-color-paint',
                'trItemId' => "tr-item-color-paint-$colorPaint->id",
            ],
            headers: [
                'Content-Type' => 'text/vnd.turbo-stream.html',
            ],
        );
    }

    public function deleteColor(Request $request): void
    {
        HAlert::alert(Color::find($request->get('id'))->delete());
    }

    public function deleteColorPaint(Request $request): void
    {
        HAlert::alert(ColorPaint::find($request->get('id'))->delete());
    }

    public function deleteRapport(Request $request): void
    {
        HAlert::alert(Rapport::find($request->get('id'))->delete());
    }

    public function deleteFlexMaterial(Request $request): void
    {
        HAlert::alert(Material::find($request->get('id'))->delete());
    }

    public function changeMaterialField(Request $request): Response
    {
        return $this->changeFieldsResponse(Material::class, $request->get('id'), [
            $request->input('field') => $request->input('content'),
        ]);
    }

    public function changeRapportField(Request $request): Response
    {
        return $this->changeFieldsResponse(Rapport::class, $request->get('id'), [
            $request->input('field') => $request->input('content'),
        ]);
    }

    public function save(Request $request, CustomConfigs $customConfigs): void
    {
        // сохранение всех конфигов
        if ($request->filled('custom_config')) {
            foreach ($request->get('custom_config') as $configName => $value) {
                $customConfigs->set($configName, (string) $value);
            }
        }
    }

    private function changeFieldsResponse(string $model, int $id, array $parameters): Response
    {
        $model::find($id)->update($parameters);

        return \response('', 204);
    }
}
