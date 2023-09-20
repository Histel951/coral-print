<?php

namespace App\Orchid\Screens\Flex\Color;

use App\Models\Color;
use App\Models\ColorPaint;
use App\Orchid\Fields\ClearPicture;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ColorPaintCreateScreen extends Screen
{
    public Color $color;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Color $color): iterable
    {
        return [
            'color' => $color,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Создание краски для цвета \"{$this->color->name}\"";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Назад')->route('platform.flex.color.paints', [
                'color' => $this->color,
            ]),
            Button::make('Сохранить')->method('save'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('paint.name')
                    ->title('Название')
                    ->required(),

                Input::make('print.consumption')
                    ->title('Расход (л)')
                    ->step('0.001')
                    ->type('number')
                    ->min(0),

                Input::make('print.price')
                    ->title('Себес €')
                    ->step('0.01')
                    ->type('number')
                    ->min(0),

                Input::make('price.price_percent')
                    ->title('Наценка (%)')
                    ->type('number')
                    ->min(0),

                ClearPicture::make('price.image_id')
                    ->title('Превью')
                    ->targetId(),

                Select::make('color')
                    ->value($this->color->id)
                    ->fromModel(Color::class, 'name', 'id')
                    ->disabled(),
            ]),
        ];
    }

    public function save(Request $request, ColorPaint $colorPaint): void
    {
        if ($colorPaint->fill($request->input('price'))->save()) {
            Alert::success('Цвет успешно создан.');
        } else {
            Alert::warning('Цвет не создан.');
        }
    }
}
