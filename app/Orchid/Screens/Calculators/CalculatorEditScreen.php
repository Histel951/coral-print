<?php

namespace App\Orchid\Screens\Calculators;

use App\Events\CalculatorTypesCacheClearEvent;
use App\Events\MaterialCacheClearEvent;
use App\Models\Calculator;
use App\Models\CalculatorRestriction;
use App\Models\CalculatorType;
use App\Models\Cutting;
use App\Models\Lamination;
use App\Models\Material;
use App\Orchid\Fields\SvgIdPicture;
use App\Orchid\Screens\EditScreen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class CalculatorEditScreen extends EditScreen
{
    /**
     * @var Calculator
     */
    public Calculator $calculator;

    /**
     * @var Collection
     */
    public Collection $materials;

    /**
     * @var Collection
     */
    public Collection $laminations;

    /**
     * @var Collection
     */
    public Collection $cutting;

    /**
     * Query data.
     *
     * @param Calculator $calculator
     * @return array
     */
    public function query(Calculator $calculator): iterable
    {
        $calculator->load('attachment');

        return [
            'calculator' => $calculator,
            'materials' => $calculator->materials,
            'laminations' => $calculator->laminations,
            'cuttings' => $calculator->cuttings,
            'restriction' => $calculator->restrictions->first(),
            'restrictionMessage' => $calculator->restrictions->first()?->messages,
            'page' => $calculator->page,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Редактирование калькулятора \"{$this->calculator->name}\" [{$this->calculator->id}]";
    }

    public function description(): ?string
    {
        return $this->calculator->description;
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
                'Калькулятор' => [
                    Layout::rows([
                        Input::make('calculator.name')
                            ->title('Название калькулятора')
                            ->placeholder('Название..')
                            ->required(),

                        TextArea::make('calculator.description')
                            ->title('Описание калькулятора')
                            ->placeholder('Описание..'),

                        CheckBox::make('calculator.active')
                            ->title('Активен ли калькулятор')
                            ->sendTrueOrFalse()
                            ->placeholder('Активный ли калькулятор'),

                        Select::make('calculator.calculator_type_id')
                            ->fromModel(CalculatorType::class, 'name', 'id')
                            ->required(),

                        Input::make('calculator.sequence')
                            ->title('Порядок')
                            ->type('number')
                            ->required()
                            ->placeholder(1),

                        Input::make('calculator.min_price')
                            ->title('Минимальная стоимость')
                            ->type('number')
                            ->required(),

                        Input::make('calculator.width_without_print')
                            ->title('Ширина печати (если отсутствует печать)')
                            ->type('number')
                            ->required(),
                    ]),
                ],
                'Изображение' => [
                    Layout::rows([SvgIdPicture::make('calculator.svg_id')->title('ID svg картинки калькулятора:')]),
                ],
                'Материалы' => [
                    Layout::rows([
                        Matrix::make('materials')
                            ->columns([
                                'Материал' => 'id',
                            ])
                            ->fields([
                                'id' => Relation::make()->fromModel(Material::class, 'name', 'id'),
                            ])
                            ->title('Материалы'),
                    ]),
                ],
                'Ламинации' => [
                    Layout::rows([
                        Matrix::make('laminations')
                            ->columns([
                                'Ламинация' => 'id',
                            ])
                            ->fields([
                                'id' => Relation::make()->fromModel(Lamination::class, 'name', 'id'),
                            ]),
                    ]),
                ],
                'Нарезки' => [
                    Layout::rows([
                        Matrix::make('cuttings')
                            ->columns([
                                'Нарезка' => 'id',
                            ])
                            ->fields([
                                'id' => Relation::make()->fromModel(Cutting::class, 'name', 'id'),
                            ]),
                    ]),
                ],
                'Ограничения' => [
                    Layout::rows([
                        Input::make('restriction.max_size')
                            ->title('Максимальный размер')
                            ->type('number'),

                        Input::make('restriction.min_size')
                            ->title('Минимальный размер')
                            ->type('number'),
                    ]),
                    Layout::rows([
                        Matrix::make('restrictionMessage')
                            ->columns([
                                'Текст' => 'text',
                                'Ограничение по печати' => 'is_print_restrict',
                                'Сообщение при исключении' => 'is_extra',
                            ])
                            ->fields([
                                'text' => TextArea::make(),
                                'is_print_restrict' => CheckBox::make()->sendTrueOrFalse(),
                                'is_extra' => CheckBox::make()->sendTrueOrFalse(),
                            ]),
                    ]),
                ],
                'Страница' => [
                    Layout::rows([
                        Quill::make('page.print_time_description')
                            ->title('Описание сроков печати:')
                            ->height('150px')
                            ->toolbar(['text', 'color', 'header', 'list', 'format', 'media']),

                        CheckBox::make('page.is_show_constructor')
                            ->title('Показать конструктор')
                            ->sendTrueOrFalse(),
                    ])->title('Описание изделия'),
                ],
            ]),
        ];
    }

    /**
     * Обновляет данные калькулятора
     * @param Request $request
     * @param Calculator $calculator
     * @return void
     */
    public function edit(Request $request, Calculator $calculator): void
    {
        $this->syncUnique($calculator->materials(), $request->get('materials', []));
        $this->syncUnique($calculator->laminations(), $request->get('laminations', []));
        $this->syncUnique($calculator->cuttings(), $request->get('cuttings', []));

        $calculator->page()->delete();
        $newPageOptions = $calculator->page()->updateOrCreate($request->get('page'));

        $calculator->update([
            'calculator_page_id' => $newPageOptions->getKey(),
        ]);

        $restriction = CalculatorRestriction::query()->updateOrCreate(
            ['calculator_id' => $calculator->id],
            $request->get('restriction'),
        );

        $restriction->messages()->delete();
        foreach ($request->get('restrictionMessage') as $message) {
            $restriction->messages()->create(['error_fields' => ['width_height', 'diameter'], ...$message]);
        }

        $request->request->remove('calculator.materials');
        $request->request->remove('calculator.laminations');
        $request->request->remove('calculator.cuttings');

        if ($calculator->fill($request->get('calculator'))->save()) {
            $calculator->attachment()->syncWithoutDetaching($request->get('calculator.attachment', []));

            event(new CalculatorTypesCacheClearEvent());
            event(new MaterialCacheClearEvent());
            Alert::success('Калькулятор успешно обновлён!');
        } else {
            Alert::warning('Калькулятор не обновлён.');
        }
    }

    public function delete(Calculator $calculator): RedirectResponse
    {
        $calculator->delete();

        return redirect()->route('platform.calculators');
    }
}
