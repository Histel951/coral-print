<?php

namespace App\Orchid\Filters\Material;

use App\Models\MaterialCategory;
use App\Models\MaterialType;
use App\Models\PrintSpecie;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;

class MaterialFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'материалы';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder;
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Input::make('filter[id]')
                ->type('number')
                ->placeholder('26')
                ->value($this->request->get('filter[id]'))
                ->title('ID материала'),

            Input::make('filter[name]')
                ->placeholder('Прозрачная глянцевая..')
                ->value($this->request->get('filter[name]'))
                ->title('Название'),

            Input::make('filter[type_name]')
                ->placeholder('пленка')
                ->value($this->request->get('filter[type_name]'))
                ->title('Название типа'),

            Input::make('filter[price_percent]')
                ->placeholder('70')
                ->type('number')
                ->value($this->request->get('filter[price_percent]'))
                ->title('Процент наценки'),

            Input::make('filter[price]')
                ->type('number')
                ->step('0.01')
                ->title('Цена')
                ->value($this->request->get('filter[price]'))
                ->placeholder('400.00'),

            Input::make('filter[const_price]')
                ->type('number')
                ->step('0.01')
                ->title('Себестоимость')
                ->value($this->request->get('filter[const_price]'))
                ->placeholder('200.00'),

            Input::make('filter[extra_change]')
                ->type('number')
                ->step('0.01')
                ->value($this->request->get('filter[extra_change]'))
                ->placeholder('100.00'),

            Input::make('filter[article]')
                ->value($this->request->get('filter[article]'))
                ->title('Артикул')
                ->placeholder('H886 62xps 517 / Itraco'),

            Input::make('filter[min_meters]')
                ->value($this->request->get('filter[min_meters]'))
                ->title('Мин. метров')
                ->type('number')
                ->placeholder('100'),

            Relation::make('filter[print_specie_id]')
                ->value($this->request->get('filter[print_specie_id]'))
                ->fromModel(PrintSpecie::class, 'name', 'id')
                ->title('Разновидость печати'),

            Input::make('filter[sequence]')
                ->value($this->request->get('filter[sequence]'))
                ->type('number')
                ->title('Последовательность')
                ->placeholder('31'),

            Input::make('filter[width]')
                ->value($this->request->get('filter[width]'))
                ->type('number')
                ->title('Ширина')
                ->placeholder('215'),

            Input::make('filter[weight]')
                ->value($this->request->get('filter[weight]'))
                ->type('number')
                ->title('Вес')
                ->placeholder('235'),

            CheckBox::make('filter[is_hex]')
                ->checked((bool) $this->request->get('filter[is_hex]'))
                ->title('Хекс цвета')
                ->sendTrueOrFalse(),

            Relation::make('filter[material_type_id]')
                ->title('Тип материала')
                ->value($this->request->get('filter[material_type_id]'))
                ->fromModel(MaterialType::class, 'name', 'id'),

            Relation::make('filter[material_category_id]')
                ->title('Категория материала')
                ->value($this->request->get('filter[material_category_id]'))
                ->fromModel(MaterialCategory::class, 'name', 'id'),

            Input::make('filter[volume]')
                ->title('Объём')
                ->value($this->request->get('filter[volume]'))
                ->type('number')
                ->placeholder('120'),

            CheckBox::make('filter[is_show]')
                ->title('Показывать')
                ->checked((bool) $this->request->get('filter[is_show]'))
                ->sendTrueOrFalse(),
        ];
    }
}
