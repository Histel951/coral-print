<?php

namespace App\Orchid\Layouts\Flex\Color;

use App\Models\ColorPaint;
use App\Orchid\Fields\ClearPicture;
use App\Orchid\Fields\ModalToggleTurbo;
use App\Orchid\Fields\Span;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class ColorPaintLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'paints';

    protected string $trItemId = 'tr-item-color-paint-{id}';

    protected string $tBodyId = 'table-tbody-color-paint';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('name', 'Название')
                ->render(
                    fn (ColorPaint $colorPaint) => Span::make()->changeField(
                        method: 'changeColorPaintField',
                        field: 'name',
                        model: $colorPaint,
                        mainUrl: route('platform.flex'),
                    ),
                )
                ->sort(),
            TD::make('consumption', 'Расход(л)')
                ->render(
                    fn (ColorPaint $colorPaint) => Span::make()->changeField(
                        method: 'changeColorPaintField',
                        field: 'consumption',
                        model: $colorPaint,
                        mainUrl: route('platform.flex'),
                    ),
                )
                ->sort(),
            TD::make('price', 'Себес (€)')
                ->render(
                    fn (ColorPaint $colorPaint) => Span::make()->changeField(
                        method: 'changeColorPaintField',
                        field: 'price',
                        model: $colorPaint,
                        mainUrl: route('platform.flex'),
                    ),
                )
                ->sort(),
            TD::make('image_id', 'Превью')->render(function (ColorPaint $colorPaint) {
                return ClearPicture::make()
                    ->mainurl(route('platform.flex'))
                    ->changeable()
                    ->issmall()
                    ->method('changeColorPaintPicture', [
                        'id' => $colorPaint->id,
                    ])
                    ->field('image_id')
                    ->value($colorPaint->image->id)
                    ->targetId();
            }),

            TD::make('actions', ' ')
                ->render(function (ColorPaint $colorPaint) {
                    return ModalToggleTurbo::make()
                        ->mainurl(route('platform.flex'))
                        ->modalTitle('Удаление краски')
                        ->modal('confirmDeleteColorPaint')
                        ->method('deleteColorPaint')
                        ->asyncParameters([
                            'id' => $colorPaint->id
                        ])
                        ->type(Color::DANGER())
                        ->icon('admin.trash');
                })
        ];
    }

    protected function viewData(Repository $repository): array
    {
        return [
            'addItemRequestData' => [
                'method' => 'addNewColorPaint',
            ],
        ];
    }
}
