<?php

namespace App\Orchid\Layouts\Flex;

use App\Models\Color;
use App\Models\ColorPaint;
use App\Orchid\Fields\ModalToggleTurbo;
use App\Orchid\Fields\Span;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;

class ColorLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'colors';

    protected string $trItemId = 'tr-item-color-{id}';
    protected string $tBodyId = 'table-tbody-colors';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('name', 'Название')
                ->render(
                    fn (Color $color) => Span::make()->changeField(
                        method: 'changeColorField',
                        field: 'name',
                        model: $color,
                        mainUrl: route('platform.flex'),
                    ),
                )
                ->sort(),
            TD::make('paints', 'Краски')->render(function (Color $color) {
                $html = '';

                $color->paints->each(function (ColorPaint $paint) use (&$html) {
                    $html .= sprintf(
                        '<div><img style=\'%s\' src=\'%s\' alt=\'%s\'>%s<br></div>',
                        'height:12px;width:12px;border-radius:50%;border:1px solid #c5c5c5;margin-right:4px',
                        $paint->image->url(),
                        $paint->name,
                        $paint->name,
                    );
                });

                return $html;
            }),
            TD::make('change_paints', 'Зависимость красок')->render(function (Color $color) {
                return Link::make('Изменить')->route('platform.flex.color.change.paints', [
                    'color' => $color,
                ]);
            }),

            TD::make('actions', ' ')
                ->render(function (Color $color) {
                    return ModalToggleTurbo::make()
                        ->mainurl(route('platform.flex'))
                        ->modalTitle('Удаление цвета')
                        ->modal('confirmDeleteColor')
                        ->method('deleteColor')
                        ->asyncParameters([
                            'id' => $color->id
                        ])
                        ->type(\Orchid\Support\Color::DANGER())
                        ->icon('admin.trash');
                })
        ];
    }

    protected function viewData(Repository $repository): array
    {
        return [
            'addItemRequestData' => [
                'method' => 'addColor',
            ],
        ];
    }
}
