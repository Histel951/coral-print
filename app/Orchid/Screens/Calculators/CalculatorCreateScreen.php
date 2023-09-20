<?php

namespace App\Orchid\Screens\Calculators;

use App\Models\Calculator;
use App\Models\CalculatorType;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class CalculatorCreateScreen extends Screen
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
        return 'Создание нового калькулятора';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Button::make('Создать')->method('create')];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('name')->title('Название калькулятора'),

                TextArea::make('description')->title('Описание калькулятора'),

                Input::make('min_price')
                    ->title('Минимальная цена')
                    ->type('number')
                    ->required(),

                CheckBox::make('active')
                    ->title('Активный ли калькулятор')
                    ->checked()
                    ->sendTrueOrFalse(),

                Select::make('calculator_type_id')
                    ->title('Тип калькулятора')
                    ->fromModel(CalculatorType::class, 'name'),

                Input::make('sequence')
                    ->title('Порядок')
                    ->placeholder(1)
                    ->required()
                    ->type('number')
                    ->value(1),

                Input::make('calculator.width_without_print')
                    ->title('Ширина печати <sup style="color: #5f5f5f">(если отсутствует печать)</sup>')
                    ->type('number')
                    ->value(1200)
                    ->required(),

                Input::make('min_price')
                    ->title('Минимальная стоимость')
                    ->type('number')
                    ->required(),

                Matrix::make('parameters')
                    ->columns(['is_wide', 'is_notepads', 'is_low_pages', 'is_adhesive'])
                    ->title('Параметры')
                    ->fields([
                        'is_wide' => CheckBox::make()->sendTrueOrFalse(false),
                        'is_low_pages' => CheckBox::make()->sendTrueOrFalse(false),
                        'is_adhesive' => CheckBox::make()->sendTrueOrFalse(false),
                        'is_notepads' => CheckBox::make()->sendTrueOrFalse(false),
                    ])
                    ->maxRows(1),

                Picture::make('image_id')
                    ->title('Изображение калькулятора')
                    ->targetId(),
            ]),
        ];
    }

    /**
     * Создаёт новый калькулятор
     * @param Request $request
     * @return void
     */
    public function create(Request $request): void
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['string'],
            'image_id' => ['integer'],
            'calculator_type_id' => ['integer'],
            'parameters' => [],
            'active' => ['boolean'],
            'min_price' => ['required', 'integer'],
        ]);

        if (isset($validated['calculator']['parameters'])) {
            $validated['parameters'] =
                $validated['calculator']['parameters'][array_key_first($validated['parameters'])];
        }

        Calculator::create($validated);

        Alert::success('Калькулятор успешно создан!');
    }
}
