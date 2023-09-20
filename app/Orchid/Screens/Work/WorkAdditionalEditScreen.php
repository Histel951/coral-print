<?php

namespace App\Orchid\Screens\Work;

use App\Events\WorkAdditionalCacheClearEvent;
use App\Models\Formula;
use App\Models\WorkAdditional;
use App\Models\WorkAdditionalPrice;
use App\Orchid\Layouts\WorkAdditionalFormulaListener;
use App\Orchid\Module\Print\BreadCrumbsCookie;
use App\Orchid\Screens\EditScreen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class WorkAdditionalEditScreen extends EditScreen
{
    /**
     * @var WorkAdditional
     */
    public WorkAdditional $workAdditional;

    /**
     * ID формулы из query
     * @var int
     */
    public $formula_id;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(WorkAdditional $workAdditional): iterable
    {
        return [
            'hiddenWidthHeight' => $workAdditional->formula->is_use_volume,
            'workAdditional' => $workAdditional,
            'formula_id' => $workAdditional->formula->id,
            'weight' => $workAdditional->weight,
            'volume' => $workAdditional->volume,
            'saveWeight' => $workAdditional->weight,
            'saveVolume' => $workAdditional->volume,
            'workAdditionalPrices' => $workAdditional->prices,
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Link::back(BreadCrumbsCookie::WorkAdditionalPrint, 'platform.works.additionals', [
                'filter[work_additional_type_id]' => $this->workAdditional->work_additional_type_id,
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
        return "Редактирование доп работы: \"{$this->workAdditional->name}\" [{$this->workAdditional->id}]";
    }

    public function asyncHiddenWidthHeight(int $formula_id = null, int $weight = null, int $volume = null): array
    {
        $isHiddenWidthHeight = Formula::find($formula_id)->is_use_volume;

        return [
            'formula_id' => $formula_id,
            'weight' => $weight,
            'volume' => $volume,
            'hiddenWidthHeight' => $isHiddenWidthHeight,
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
                'Доп. работа' => [
                    Layout::rows([
                        Input::make('workAdditional.name')
                            ->title('Название')
                            ->required()
                            ->placeholder('Люверсы..'),

                        Select::make('workAdditional.color')
                            ->title('Цвет')
                            ->options([
                                '#309aee' => 'blue',
                                '#0ea586' => 'green',
                                '#fda601' => 'orange',
                                '#652bb3' => 'violet',
                                '#032c62' => 'darkblue',
                            ]),

                        Input::make('workAdditional.code')
                            ->title('Тэг')
                            ->placeholder('#люверсы'),
                    ]),
                    WorkAdditionalFormulaListener::class,
                ],
                'Цены доп. работы' => [
                    Layout::rows([
                        Matrix::make('workAdditionalPrices')
                            ->columns([
                                'Листаж/Метраж(Л)' => 'list_meters',
                                'Тираж(Т)' => 'circulation',
                                'Цена(Ц)' => 'price',
                                'Фиккс. сумма(ФС)' => 'fixed_sum',
                                'Процент' => 'percent',
                                'Розн наценка(%)' => 'charge',
                            ])
                            ->fields($this->priceFields()),
                    ]),
                ],
            ]),
        ];
    }

    private function priceFields(): array
    {
        $fields = [
            'list_meters' => Input::make()->type('number'),
            'circulation' => Input::make()->type('number'),
            'price' => Input::make()
                ->step('0.01')
                ->type('number'),
            'fixed_sum' => Input::make()
                ->step('0.01')
                ->type('number'),
            'percent' => Input::make()->type('number'),
            'charge' => Input::make()->type('number'),
        ];

        // formula_id => fields[]
        $unblockFields = [
            4 => ['circulation', 'price', 'charge'],
            2 => ['fixed_sum', 'charge'],
            3 => ['circulation', 'price', 'charge'],
            5 => ['percent', 'charge'],
            6 => ['list_meters', 'price', 'charge'],
            8 => ['fixed_sum', 'charge'],
            7 => ['circulation', 'price', 'charge'],
            1 => ['circulation', 'price', 'charge'],
        ];

        foreach ($unblockFields as $formula_id => $formFields) {
            if ($formula_id == $this->formula_id) {
                foreach ($fields as $fieldName => $field) {
                    if (!in_array($fieldName, $formFields)) {
                        $fields[$fieldName] = $field->disabled();
                    }
                }
            }
        }

        return $fields;
    }

    public function edit(WorkAdditional $workAdditional, Request $request)
    {
        $ids = collect($request->get('workAdditionalPrices', []))->map(
            fn (array $parameters) => WorkAdditionalPrice::query()->create($parameters)?->id,
        );

        $this->syncUnique($workAdditional->prices(), $ids);

        if (
            $workAdditional
                ->fill(
                    Arr::collapse([
                        $request->get('workAdditional'),
                        [
                            'formula_id' => $request->get('formula_id'),
                            'weight' => $request->get('weight', 0) ?? 0,
                            'volume' => $request->get('volume', 0) ?? 0,
                        ],
                    ]),
                )
                ->save()
        ) {
            event(new WorkAdditionalCacheClearEvent());
            Alert::success('Доп. работа успешно обновлена!');
        } else {
            Alert::warning('Доп. работа не обновлена.');
        }
    }

    public function delete(WorkAdditional $workAdditional): RedirectResponse
    {
        $workAdditional->delete();
        event(new WorkAdditionalCacheClearEvent());

        return redirect()->route('platform.print.works.additionals', [
            'filter[work_additional_type_id]' => $workAdditional->work_additional_type_id,
        ]);
    }
}
