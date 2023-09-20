<?php

namespace App\Orchid\Layouts\Material;

use App\Models\Material;
use App\Orchid\Custom\CustomTD;
use App\Orchid\Layouts\StandardTable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class MaterialListLayout extends StandardTable
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'materials';

    protected string $editRoute = 'platform.material.edit';

    protected function standardColumns(): iterable
    {
        return [
            TD::make('name', 'Название'),

            TD::make('type_name', 'Название типа материала'),
            TD::make('desc', 'Описание'),
            TD::make('price_percent', 'Наценка в процентах')->sort(),

            TD::make('price', 'Цена')->sort(),

            TD::make('cost_price', 'Себестоимость')->sort(),

            TD::make('extra_change', 'extra_change')->sort(),

            TD::make('article', 'Артикул'),
            TD::make('min_meters', 'Мин. метров')->sort(),

            TD::make('print_specie.name', 'Печать')->sort(),

            TD::make('sequence', 'Последовательность')->sort(),

            TD::make('width', 'ширина')->sort(),

            TD::make('weight', 'Вес')->sort(),

            TD::make('is_hex', 'Hex')->render(function (Material $material) {
                return CheckBox::make('is_hex')
                    ->checked((bool) $material->is_hex)
                    ->disabled();
            }),

            TD::make('type.name', 'Тип материала')
                ->render(function (Material $material) {
                    return Link::make($material->type?->name)->route('platform.material.type.edit', $material->type);
                })
                ->sort(),

            TD::make('category.name', 'Категория материала')
                ->sort()
                ->render(function (Material $material) {
                    return Link::make($material->category?->name)->route(
                        'platform.material.category.edit',
                        $material->category,
                    );
                }),

            TD::make('volume', 'объём')->sort(),

            TD::make('is_show', 'Показывать')->render(function (Material $material) {
                return CheckBox::make('is_show')->disabled();
            }),

            TD::make('action', 'Действие')->render(function (Material $material) {
                return CustomTD::make()->optionButtons('platform.material.edit', $material);
            }),
        ];
    }
}
