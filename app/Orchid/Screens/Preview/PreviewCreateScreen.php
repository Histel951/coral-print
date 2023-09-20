<?php

namespace App\Orchid\Screens\Preview;

use App\Events\PreviewCacheClearEvent;
use App\Models\Calculator;
use App\Models\Cutting;
use App\Models\Preview;
use App\Models\PrintForm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PreviewCreateScreen extends Screen
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
        return 'Создать превью';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Button::make('Сохранить')->method('create')];
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
                Picture::make('preview.image')
                    ->title('Изображение')
                    ->targetId(),

                Select::make('preview.calculator_id')
                    ->fromModel(Calculator::class, 'name', 'id')
                    ->title('Калькулятор')
                    ->empty('Не выбрано'),

                Select::make('preview.cutting_id')
                    ->fromModel(Cutting::class, 'name', 'id')
                    ->title('Нарезка')
                    ->empty(),

                Select::make('preview.form_id')
                    ->fromModel(PrintForm::class, 'name', 'id')
                    ->title('Форма')
                    ->empty(),

                CheckBox::make('preview.is_changeable')
                    ->title('Масштабируемая')
                    ->value(false)
                    ->sendTrueOrFalse(),

                Input::make('preview.sequence')
                    ->title('Порядок')
                    ->type('number')
                    ->placeholder('12'),
            ]),
        ];
    }

    public function create(Request $request, Preview $preview): RedirectResponse
    {
        $calculatorTypeId = Calculator::query()
            ->find($request->get('preview')['calculator_id'])
            ->calculatorType()
            ->first()->id;

        if (
            $preview
                ->fill(
                    Arr::collapse([
                        $request->get('preview'),
                        [
                            'calculator_type_id' => $calculatorTypeId,
                        ],
                    ]),
                )
                ->save()
        ) {
            Alert::success('Превью создано');
            event(new PreviewCacheClearEvent());

            return redirect()->route('platform.preview.edit', $preview);
        } else {
            Alert::success('Превью не создано');
            return redirect()->route('platform.preview.create');
        }
    }
}
