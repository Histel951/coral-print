<?php

namespace App\Orchid\Screens\Flex\Color;

use App\Helpers\SyncDetaching;
use App\Models\Color;
use App\Models\ColorPaint;
use App\Orchid\Fields\ClearPicture;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class ColorChangePaintsScreen extends Screen
{
    use SyncDetaching;

    public Color $color;

    /**
     * @param Color $color
     * @return iterable
     */
    public function query(Color $color): iterable
    {
        return [
            'color' => $color,
            'paints' => $color->paints,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return "Изменение красок для цвета \"{$this->color->name}\" [{$this->color->id}]";
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [Button::make('Сохранить')->method('save')];
    }

    /**
     * @return iterable
     * @throws BindingResolutionException
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Matrix::make('paints')
                    ->fields([
                        'id' => Select::make()->fromModel(ColorPaint::class, 'name', 'id'),
                        'image_id' => ClearPicture::make()
                            ->targetId()
                            ->changeable(false),
                    ])
                    ->columns([
                        'Краски' => 'id',
                        'Превью' => 'image_id',
                    ]),
            ]),
        ];
    }

    public function save(Request $request, Color $color)
    {
        $this->syncUnique($color->paints(), $request->input('paints', []));
    }
}
