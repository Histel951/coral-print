<?php

namespace App\Orchid\Screens\Flex\Color;

use App\Models\ColorPaint;
use App\Orchid\Fields\ClearPicture;
use App\Orchid\Screens\EditScreen;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ColorPaintEditScreen extends EditScreen
{
    public ColorPaint $colorPaint;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(ColorPaint $colorPaint): iterable
    {
        return [
            'colorPaint' => $colorPaint,
        ];
    }

    public function name(): ?string
    {
        return "Редактирование \"{$this->colorPaint->name}\" [{$this->colorPaint->id}]";
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
                Input::make('colorPaint.name')
                    ->title('Название')
                    ->required(),

                Input::make('colorPaint.consumption')
                    ->title('Расход (л)')
                    ->step('0.001')
                    ->type('number')
                    ->min(0),

                Input::make('colorPaint.price')
                    ->title('Себестоимость (€)')
                    ->step('0.01')
                    ->type('number')
                    ->min(0),

                Input::make('colorPaint.price_percent')
                    ->title('Наценка (%)')
                    ->type('number')
                    ->min(0),

                ClearPicture::make('colorPaint.image_id')
                    ->title('Превью')
                    ->targetId(),
            ]),
        ];
    }

    public function edit(Request $request, ColorPaint $colorPaint): void
    {
        if ($colorPaint->fill($request->input('colorPaint'))->save()) {
            Alert::success('Краска успешно обновлена.');
        } else {
            Alert::error('Краска не обновлена');
        }
    }

    public function delete(ColorPaint $colorPaint): void
    {
        $colorPaint->delete();
    }
}
