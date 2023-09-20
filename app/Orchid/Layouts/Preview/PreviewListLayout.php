<?php

namespace App\Orchid\Layouts\Preview;

use App\Models\Preview;
use App\Orchid\Custom\CustomTD;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\TD;

class PreviewListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'previews';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('calculator.name', 'Калькулятор'),
            TD::make('cutting.name', 'Нарезка'),
            TD::make('form.name', 'Форма'),

            TD::make('image', 'Превью')->render(function (Preview $preview): string {
                return "<img src='{$preview->previewImage?->url()}'>";
            }),

            TD::make('action', 'Действие')->render(function (Preview $preview) {
                return CustomTD::make()->optionButtons('platform.preview.edit', $preview);
            }),
        ];
    }
}
