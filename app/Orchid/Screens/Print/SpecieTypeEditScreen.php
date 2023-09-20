<?php

namespace App\Orchid\Screens\Print;

use App\Events\SpecieTypeCacheClearEvent;
use App\Models\SpecieType;
use App\Models\SpecieTypePaint;
use App\Models\SpecieTypePrice;
use App\Orchid\Module\Print\BreadCrumbsCookie;
use App\Orchid\Screens\EditScreen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\RadioButtons;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class SpecieTypeEditScreen extends EditScreen
{
    public SpecieType $specieType;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(SpecieType $specieType): iterable
    {
        return [
            'specieType' => $specieType,
            'prices' => $specieType->prices,
            'paints' => $specieType->paints,
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Link::back(BreadCrumbsCookie::MaterialPrint, 'platform.module.print.materials', [
                'filter[print_specie_id]' => $this->specieType->print_specie_id,
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
        return $this->specieType->name;
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        if ($this->specieType->is_paints) {
            $layoutPrices = [
                'Цены' => [
                    Layout::rows([
                        Matrix::make('paints')
                            ->columns([
                                'Количество' => 'quantity',
                                'Цвет 1' => 'paint1',
                                'Цвет 2' => 'paint2',
                                'Цвет 3' => 'paint3',
                                'Цвет 4' => 'paint4',
                                'Цвет 5' => 'paint5',
                                'Цвет 6' => 'paint6',
                                'Цвет 7' => 'paint7',
                                'Цвет 8' => 'paint8',
                                'Наценка' => 'overprice',
                            ])
                            ->fields([
                                'quantity' => Input::make()
                                    ->type('number')
                                    ->required(),
                                'paint1' => Input::make()
                                    ->type('number')
                                    ->min(0)
                                    ->step('0.1')
                                    ->required(),
                                'paint2' => Input::make()
                                    ->type('number')
                                    ->min(0)
                                    ->step('0.1')
                                    ->required(),
                                'paint3' => Input::make()
                                    ->type('number')
                                    ->min(0)
                                    ->step('0.1')
                                    ->required(),
                                'paint4' => Input::make()
                                    ->type('number')
                                    ->min(0)
                                    ->step('0.1')
                                    ->required(),
                                'paint5' => Input::make()
                                    ->type('number')
                                    ->min(0)
                                    ->step('0.1')
                                    ->required(),
                                'paint6' => Input::make()
                                    ->type('number')
                                    ->min(0)
                                    ->step('0.1')
                                    ->required(),
                                'paint7' => Input::make()
                                    ->type('number')
                                    ->min(0)
                                    ->step('0.1')
                                    ->required(),
                                'paint8' => Input::make()
                                    ->type('number')
                                    ->min(0)
                                    ->step('0.1')
                                    ->required(),
                                'overprice' => Input::make()
                                    ->type('number')
                                    ->required(),
                            ]),
                    ]),
                ],
            ];
        } else {
            $layoutPrices = [
                'Цены' => [
                    Layout::rows([
                        Matrix::make('prices')
                            ->columns([
                                'Количество' => 'quantity',
                                'Себестоимость' => 'price',
                                'Наценка' => 'overprice',
                            ])
                            ->fields([
                                'quantity' => Input::make()
                                    ->type('number')
                                    ->required(),
                                'price' => Input::make()
                                    ->type('number')
                                    ->required()
                                    ->step('0.01'),
                                'overprice' => Input::make()
                                    ->type('number')
                                    ->required(),
                            ]),
                    ]),
                ],
            ];
        }

        return [
            Layout::columns([
                Layout::tabs([
                    'Печать' => [
                        Layout::rows([
                            Input::make('specieType.name')
                                ->title('Название')
                                ->placeholder('Печать'),

                            Input::make('specieType.index_name')->title('Индекс'),

                            Input::make('specieType.type_name')
                                ->title('Название типа печати')
                                ->placeholder('Pechaty 1/4'),

                            Input::make('specieType.height')
                                ->title('$h')
                                ->type('number')
                                ->placeholder('440'),

                            Input::make('specieType.width')
                                ->title('$w')
                                ->type('number')
                                ->placeholder('440'),

                            RadioButtons::make('specieType.type')
                                ->options([
                                    2 => 'Стандартный расчёт',
                                    1 => 'Линейная интерполяция',
                                ])
                                ->value(1),

                            Input::make('specieType.duplex')
                                ->type('number')
                                ->placeholder('0')
                                ->title('Коэффициент дуплекса'),
                        ]),
                    ],
                    ...$layoutPrices,
                ]),
            ]),
        ];
    }

    public function edit(Request $request, SpecieType $specieType)
    {
        if ($request->filled('prices')) {
            $this->changePrices($request->get('prices'), $specieType);
        }

        if ($request->filled('paints')) {
            $this->changePaints($request->get('paints'), $specieType);
        }

        if ($specieType->fill($request->get('specieType'))->save()) {
            event(new SpecieTypeCacheClearEvent());
            Alert::success('Разновидность печати успешно обновлена!');
        } else {
            Alert::success('Разновидность печати не обновлена.');
        }
    }

    public function delete(SpecieType $specieType): RedirectResponse
    {
        $printSpecie = $specieType->print_specie_id;
        $specieType->delete();
        event(new SpecieTypeCacheClearEvent());

        return redirect()->route('platform.module.print.materials', [
            'filter[print_specie_id]' => $printSpecie,
        ]);
    }

    public function changePaints(array $paints, SpecieType $specieType): void
    {
        SpecieTypePaint::query()
            ->where('specie_type_id', $specieType->id)
            ->delete();

        foreach ($paints as $paint) {
            SpecieTypePaint::query()->create(
                Arr::collapse([
                    $paint,
                    [
                        'specie_type_id' => $specieType->id,
                    ],
                ]),
            );
        }
    }

    private function changePrices(array $prices, SpecieType $specieType): void
    {
        SpecieTypePrice::query()
            ->where('species_type_id', $specieType->id)
            ->delete();

        foreach ($prices as $price) {
            SpecieTypePrice::query()->create([
                'quantity' => $price['quantity'],
                'price' => $price['price'],
                'overprice' => $price['overprice'],
                'species_type_id' => $specieType->id,
            ]);
        }
    }
}
