<?php

namespace App\Orchid\Screens\Design;

use App\Models\CalculatorType;
use App\Models\Design;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class DesignCreateScreen extends Screen
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
        return 'Создать дизайн';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Button::make('Сохранить')->method('save')];
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
                    Input::make('design.name')
                        ->title('Название')
                        ->placeholder('stickers..'),

                    Relation::make('design.calculator_type_id')
                        ->title('Тип калькулятора')
                        ->fromModel(CalculatorType::class, 'name', 'id'),
                ]),
            ]),
        ];
    }

    public function save(Design $design, Request $request): void
    {
        if ($design->fill($request->get('design'))->save()) {
            Alert::success('Дизайн успешно создан!');
        } else {
            Alert::warning('Дизайн не создан.');
        }
    }
}
