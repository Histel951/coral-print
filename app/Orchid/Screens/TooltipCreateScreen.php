<?php

namespace App\Orchid\Screens;

use App\Http\Requests\TooltipRequest;
use App\Models\CalculatorType;
use App\Models\Tooltip;
use App\Orchid\Helpers\HAlert;
use App\Orchid\Layouts\FieldsListener;
use App\Services\TooltipService;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Code;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class TooltipCreateScreen extends Screen
{
    public Tooltip $tooltip;
    public TooltipService $tooltipService;

    public function __construct(Tooltip $tooltip, TooltipService $tooltipService)
    {
        $this->tooltip = $tooltip;
        $this->tooltipService = $tooltipService;
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'tooltip.calculator_type_id' => CalculatorType::first()->id,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Создать подсказку';
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')
                ->method('save')
                ->id('submitBtn'),
        ];
    }

    public function asyncFields(Request $request): array
    {
        return [
            'tooltip.calculator_type_id' => $request->input('tooltip.calculator_type_id'),
            'tooltip.field_id' => $request->input('tooltip.field_id'),
        ];
    }

    /**
     * Views.
     *
     * @return iterable
     */
    public function layout(): iterable
    {
        return [
            FieldsListener::class,

            Layout::rows([
                Input::make('tooltip.name')->title('Название'),

                Select::make('tooltip.type')
                    ->id('tooltipTypes')
                    ->options($this->tooltipService->getTypes())
                    ->title('Тип'),

                CheckBox::make('tooltip.is_active')
                    ->title('Активен')
                    ->sendTrueOrFalse(),

                Code::make('tooltip.content')
                    ->title('Текст')
                    ->language(Code::MARKUP)
                    ->lineNumbers(),
            ]),
        ];
    }

    public function save(TooltipRequest $request, Tooltip $tooltip)
    {
        if ($tooltip->fill($request->get('tooltip'))->save()) {
            Toast::success(HAlert::SUCCESS_MSG);

            return redirect()->route('platform.tooltips');
        } else {
            Alert::warning(HAlert::ERROR_MSG);
        }
    }
}
