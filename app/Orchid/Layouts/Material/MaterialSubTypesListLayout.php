<?php

namespace App\Orchid\Layouts\Material;

use App\Models\MaterialSubType;
use App\Orchid\Custom\CustomTD;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\TD;

class MaterialSubTypesListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'materialSubTypes';

    protected string $editRoute = 'platform.material.sub.type.edit';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('name', 'Название'),

            TD::make('const_price', 'Себестоимость')->sort(),

            TD::make('extra_change', 'extra_change')->sort(),

            TD::make('price', 'Цена')->sort(),

            TD::make('image_id', 'Изображение')->render(function (MaterialSubType $materialSubType) {
                return "<img src='{$materialSubType->image?->url()}'>";
            }),

            TD::make('sequence', 'Последовательность'),
            TD::make('material.name', 'Материал')->render(function (MaterialSubType $materialSubType) {
                return Link::make($materialSubType->material?->name)->route(
                    'platform.material.edit',
                    $materialSubType->material,
                );
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
