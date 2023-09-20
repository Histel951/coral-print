<?php

namespace App\Orchid\Screens\Calculators;

use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Orchid\Screens\EditScreen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class CalculatorTypeEditScreen extends EditScreen
{
    /**
     * @var CalculatorType
     */
    public CalculatorType $calculatorType;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(CalculatorType $calculatorType): iterable
    {
        return [
            'calculatorType' => $calculatorType,
            'advantages' => $calculatorType->advantages,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Редактирование типа калькуляторов \"{$this->calculatorType->name}\" [{$this->calculatorType->id}]";
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
                'Тип калькулятора' => [
                    Layout::rows([
                        Input::make('calculatorType.name')
                            ->title('Название типа калькулятора')
                            ->placeholder('Название')
                            ->required(),
                    ]),
                ],

                'Калькуляторы' => [
                    Layout::rows([
                        Matrix::make('calculatorType.calculators')
                            ->columns([
                                'Калькулятор' => 'id',
                            ])
                            ->fields([
                                'id' => Relation::make()->fromModel(Calculator::class, 'name', 'id'),
                            ]),
                    ]),
                ],
                'Страница' => [
                    Layout::rows([
                        CheckBox::make('calculatorType.show_print_type')
                            ->title('Показать типы печати')
                            ->sendTrueOrFalse(),
                    ]),
                    Layout::rows([
                        Matrix::make('advantages')
                            ->columns([
                                'Изображение' => 'image_id',
                                'Заголовок' => 'title',
                                'Описание' => 'description',
                            ])
                            ->fields([
                                'image_id' => Picture::make()->targetId(),
                                'title' => Input::make()->required(),
                                'description' => Quill::make()
                                    ->height('200px')
                                    ->toolbar(['text', 'color', 'header', 'list', 'format', 'media']),
                            ]),
                    ])->title('Преимущества'),
                    Layout::rows([Input::make('calculatorType.review_title')->title('Отзывы о')]),
                ],
            ]),
        ];
    }

    /**
     * Сохраняет изменения типа калькулятора
     * @param CalculatorType $calculatorType
     * @param Request $request
     * @return void
     */
    public function edit(CalculatorType $calculatorType, Request $request): void
    {
        $this->editCalculators($request->get('calculatorType')['calculators'] ?? [], $calculatorType);

        $calculatorType->advantages()->delete();
        foreach ($request->get('advantages') as $advantage) {
            $calculatorType->advantages()->create($advantage);
        }

        if ($request->input('calculatorType.show_print_type')) {
            $this->addTooltipPrintField($calculatorType);
        } else {
            $this->removeTooltipPrintField($calculatorType);
        }

        if ($calculatorType->fill($request->get('calculatorType'))->save()) {
            Alert::success('Тип калькулятора успешно обновлён!');
        } else {
            Alert::warning('Тип калькулятора не обновлён.');
        }
    }

    public function delete(CalculatorType $calculatorType): RedirectResponse
    {
        $calculatorType->delete();

        return redirect()->route('platform.calculator.types');
    }

    private function editCalculators(array $requestCalculators, CalculatorType $calculatorType): void
    {
        $calculatorType->calculators()->each(
            fn (Calculator $calculator) => $calculator->update([
                'calculator_type_id' => null,
            ]),
        );

        foreach ($requestCalculators as $calculator) {
            Calculator::find($calculator['id'])->update([
                'calculator_type_id' => $calculatorType->id,
            ]);
        }
    }

    private function addTooltipPrintField(CalculatorType $calculatorType)
    {
        foreach ($calculatorType->calculators as $calc) {
            $calc->fields->first()->value = [...$calc->fields()->first()->value, 'tooltip_print'];
            $calc->fields->first()->save();
        }

        Cache::flush();
    }

    private function removeTooltipPrintField(CalculatorType $calculatorType)
    {
        foreach ($calculatorType->calculators as $calc) {
            $calc->fields->first()->value = [
                ...array_filter($calc->fields->first()->value, fn ($v) => $v != 'tooltip_print'),
            ];
            $calc->fields->first()->save();
        }

        Cache::flush();
    }
}
