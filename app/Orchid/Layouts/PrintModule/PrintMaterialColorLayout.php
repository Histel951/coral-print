<?php

namespace App\Orchid\Layouts\PrintModule;

use App\Models\MaterialSubType;
use App\Orchid\Custom\CustomTD;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\TD;

class PrintMaterialColorLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'materialColors';

    protected string $editRoute = 'platform.print.material.color.edit';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('id', 'id')->sort(),

            TD::make('sequence', 'Последовательность')->sort(),

            TD::make('name', 'Название'),

            TD::make('image_id', 'Изображение')->render(function (MaterialSubType $materialSubType) {
                return "<img src='{$materialSubType->image?->url()}'>";
            }),

            TD::make('color', 'Цвет')
                ->render(function (MaterialSubType $materialSubType) {
                    return "<div style='display: flex; justify-content: center' title='{$materialSubType->color}'>
                                    <div style='
                                        width: 20px;
                                        height: 20px;
                                        background-color: {$materialSubType->color};
                                        border: 1px solid #616161;
                                        border-radius: 50%;'>
                                    </div>
                                </div>";
                })
                ->alignCenter(),

            TD::make('hex', 'Хекс цвет')->render(function (MaterialSubType $materialSubType) {
                return CheckBox::make()
                    ->checked((bool) $materialSubType->hex)
                    ->disabled();
            }),

            TD::make('action', 'Действие')->render(function (MaterialSubType $materialSubType) {
                return CustomTD::make()->optionButtons('platform.material.sub.type.edit', $materialSubType);
            }),
        ];
    }
}
