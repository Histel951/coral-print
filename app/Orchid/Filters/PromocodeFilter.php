<?php

namespace App\Orchid\Filters;

use App\Models\CalculatorType;
use App\Services\ContentService;
use App\Services\PromocodeService;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;

class PromocodeFilter extends Filter
{
    public PromocodeService $promocodeService;
    public ContentService $contentService;

    public function __construct(PromocodeService $promocodeService, ContentService $contentService)
    {
        parent::__construct();
        $this->promocodeService = $promocodeService;
        $this->contentService = $contentService;
    }

    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Промокод';
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
        foreach ((array) $this->request->input('filter') as $key => $item) {
            if ($key == 'updated_at') {
                $builder = $builder->where($key, 'like', date('Y-m-d', strtotime($item)) . '%');
            } else {
                $builder = $builder->where($key, $item);
            }
        }

        if ($this->request->input('sort') == 'category') {
            $builder = $builder->orderBy('calculator_type_id', 'asc');
        }
        if ($this->request->input('sort') == '-category') {
            $builder = $builder->orderBy('calculator_type_id', 'desc');
        }

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
            Input::make('filter[email]')->title('E-mail'),

            DateTimer::make('filter[updated_at]')
                ->title('Дата')
                ->format('d.m.Y')
                ->allowInput(),

            Input::make('filter[value]')->title('Промокод'),

            Select::make('filter[is_active]')
                ->title('Статус')
                ->empty()
                ->options(['Использован', 'Активен']),

            Select::make('filter[source]')
                ->title('Источник')
                ->empty()
                ->options($this->promocodeService->getSources()),

            Select::make('filter[calculator_type_id]')
                ->title('Раздел')
                ->empty()
                ->fromModel(CalculatorType::class, 'name'),
        ];
    }
}
