<?php

namespace App\Services\Calculator\Config;

use App\Models\Bolt;
use App\Models\Calculator;
use App\Models\CalculatorSub;
use App\Models\Foiling;
use App\Models\FoilingColor;
use App\Services\Calculator\FieldTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

/**
 * Общий сервис для формирования конфигов материалов
 * (подразумевается в принципе всех возможных материалов для объекта data)
 * вне зависимости от типа калькулятора, поскольку все конфиги имеют одну структуру
 * @package ConfigMaterials
 */
class CalculatorMaterialService implements MaterialService
{
    use FieldTrait;

    /**
     * Переданный калькулятор или подкалькулятор для подтягивания данных
     * @var Calculator|CalculatorSub
     */
    protected Calculator|CalculatorSub $calculator;

    public function __construct(Calculator|CalculatorSub $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * Возвращает массив валидаторов для vue
     * @return array
     */
    public function validators(): array
    {
        $cacheKey = cache_key('service:material:validators', [
            'calculator_id' => $this->calculator->id,
            'is_calculator_sub' => $this->calculator instanceof CalculatorSub,
        ]);

        return Cache::remember(
            $cacheKey,
            now()->addMonth(),
            fn (): array => $this->calculator
                ->configs()
                ->where('name', 'validators')
                ->first()?->value ?? [],
        );
    }

    /**
     * Возвращает формы мечати для калькулятора
     * @return array
     */
    public function forms(): array
    {
        $cacheKey = cache_key('service:material:forms', [
            'calculator_id' => $this->calculator->id,
            'is_calculator_sub' => $this->calculator instanceof CalculatorSub,
        ]);

        return Cache::remember($cacheKey, now()->addDays(2), fn (): array => $this->calculator->forms->toArray());
    }

    /**
     * Получение болтов
     * @param Calculator|null $calculator
     * @return array
     */
    public function bolts(Calculator $calculator = null): array
    {
        $cacheKey = cache_key('service:material:bolts', [
            'is_calculator_sub' => $this->calculator instanceof CalculatorSub,
            'calculator_id' => $this->calculator->id,
            'calculator_parameter' => $calculator->id,
        ]);

        return Cache::tags(['service', 'material', 'bolts'])->remember($cacheKey, now()->addDays(2), function () use (
            $calculator,
        ) {
            $query = $this->calculator->bolts();

            if ($this->calculator instanceof CalculatorSub) {
                $query->where('calculator_id', $calculator->id);
            }

            return $query
                ->get()
                ?->map(
                    fn (Bolt $bolt) => [
                        'id' => $bolt->id,
                        'name' => "{$bolt->name}, {$bolt->count} болта",
                    ],
                )
                ->toArray() ?? [];
        });
    }

    /**
     * Получение массива пластика калькулятора
     * @param Calculator|null $calculator
     * @return array
     */
    public function plastic(Calculator $calculator = null): array
    {
        $cacheKey = cache_key('service:material:plastic', [
            'calculator_id' => $this->calculator->id,
            'is_calculator_sub' => $this->calculator instanceof CalculatorSub,
            'calculator_parameter' => $calculator->id,
        ]);

        return Cache::tags(['service', 'material', 'plastic'])->remember($cacheKey, now()->addDays(2), function () use (
            $calculator,
        ): array {
            $query = $this->calculator->plastic();
            if ($this->calculator instanceof CalculatorSub) {
                $query->wherePivot('calculator_id', $calculator->id);
            }

            return $query->get()?->toArray() ?? [];
        });
    }

    /**
     * Получение массива цветности
     * @param Calculator|null $calculator
     * @return array
     */
    public function chroma(Calculator $calculator = null): array
    {
        $query = $this->calculator->colors();
        if ($this->calculator instanceof CalculatorSub) {
            $query->wherePivot('calculator_id', $calculator->id);
        }

        return $query->get()?->toArray() ?? [];
    }

    /**
     * Получение позиции пружины
     * @return array
     */
    public function sprintPosition(): array
    {
        $cacheKey = cache_key('service:material:sprintPosition', [
            'calculator_id' => $this->calculator->id,
            'is_calculator_sub' => $this->calculator instanceof CalculatorSub,
        ]);

        return Cache::tags(['service', 'material', 'sprintPosition'])->remember(
            $cacheKey,
            now()->addDays(2),
            function (): array {
                if ($this->calculator instanceof CalculatorSub) {
                    return $this->calculator
                        ->sprintPosition()
                        ->where('calculator_id', $this->calculator->calculator->first()->id)
                        ->get()
                        ?->toArray() ?? [];
                }

                return $this->calculator
                    ->sprintPosition()
                    ->get()
                    ?->toArray() ?? [];
            },
        );
    }

    /**
     * Получения размеров печати
     * @return array
     */
    public function widthHeight(): array
    {
        $cacheKey = cache_key('service:material:widthHeight', [
            'calculator_id' => $this->calculator->id,
            'is_calculator_sub' => $this->calculator instanceof CalculatorSub,
        ]);

        return Cache::tags(['service', 'material', 'widthHeight'])->remember(
            $cacheKey,
            now()->addDays(2),
            function (): array {
                if ($this->calculator instanceof CalculatorSub) {
                    return $this->calculator->calculator()->calculatorType?->printSizes->toArray() ?? [];
                }

                return Arr::collapse([
                    $this->calculator->calculatorType?->printSizes?->toArray() ?? [],
                    $this->calculator->printSizes?->toArray() ?? [],
                ]);
            },
        );
    }

    /**
     * Получение количества страниц для печати
     * @return array
     */
    public function pageCount(): array
    {
        $cacheKey = cache_key('service:material:pageCount', [
            'calculator_id' => $this->calculator->id,
            'is_calculator_sub' => $this->calculator instanceof CalculatorSub,
        ]);

        return Cache::tags(['service', 'material', 'pageCount'])->remember(
            $cacheKey,
            now()->addDays(2),
            function (): array {
                if ($this->calculator instanceof CalculatorSub) {
                    return $this->calculator->calculator()->calculatorType?->pageSelect->toArray() ?? [];
                }

                return $this->calculator->calculatorType?->pageSelect->toArray() ?? [];
            },
        );
    }

    /**
     * Получение и формирование массива материалов
     * @param array|null $parameters
     * @return array
     */
    public function materials(array|null $parameters = [], array $whereParams = []): array
    {
        if (isset($parameters['white_print']) && (int) $parameters['white_print']) {
            $whereParams['pivot']['is_white_print'] = true;
        } else {
            $whereParams['pivot']['is_white_print'] = null;
        }

        $cacheKey = cache_key('service:material:materials', [
            'calculator_id' => $this->calculator->id,
            'is_calculator_sub' => $this->calculator instanceof CalculatorSub,
            'print_type' => $parameters['print_type'] ?? null,
            'work_additional_params' => $whereParams,
            'target_calculator_id' => $parameters['calculator']?->id ?? null,
        ]);

        $cache = Cache::tags(['service', 'material', 'materials']);

        if ($cache->has($cacheKey)) {
            return $cache->get($cacheKey);
        }

        $builder = $this->calculator->materials()->where('materials.is_show', '=', true);

        if ($this->calculator instanceof CalculatorSub and $parameters['calculator']) {
            $builder->wherePivot('calculator_id', $parameters['calculator']->id);
        } else {
            $print_id = isset($parameters['print_type']) ? (int) $parameters['print_type'] : null;
            $print_id = $print_id ?: $this->calculator->prints->first()?->id;

//            $builder->wherePivot('print_id', $print_id ?: null);
        }

        foreach ($whereParams as $field => $value) {
            if ($field === 'pivot') {
                foreach ($value as $pivotField => $pivotValue) {
                    $builder->wherePivot($pivotField, $pivotValue);
                }

                continue;
            }
            $builder->where($field, $value);
        }

        $materials = $this->materialStruct($builder);

        $cache->put($cacheKey, $materials, now()->addDays(2));

        return $materials;
    }

    /**
     * print_type && calculator
     * Возвращает ламинации калькулятора
     * @param array $parameters
     * @return array
     */
    public function laminations(array $parameters = []): array
    {
        $cacheKey = cache_key('service:material:laminations', [
            'calculator_id' => $this->calculator->id,
            'is_calculator_sub' => $this->calculator instanceof CalculatorSub,
            'calculator_parameters' => $parameters['calculator']?->id ?? null,
            'print' => isset($parameters['print_type']) ? (int) $parameters['print_type'] : null,
        ]);

        $cache = Cache::tags(['service', 'material', 'laminations']);

        if ($cache->has($cacheKey)) {
            return $cache->get($cacheKey);
        }

        $builder = $this->calculator->laminations();

        if (isset($parameters['print_type']) && (int) $parameters['print_type']) {
            $builder->wherePivot('print_id', (int) $parameters['print_type']);
        } else {
            $parameters['print_type'] = null;
            if ($this->calculator->prints->count() > 1 and !$this->calculator instanceof CalculatorSub) {
                $parameters['print_type'] = $this->calculator->prints->first()->id;
            }

            $builder->wherePivot('print_id', $parameters['print_type']);
        }

        if ($this->calculator instanceof CalculatorSub) {
            $builder->wherePivot('calculator_id', $parameters['calculator']->id);
        }

        $laminations = $builder->get()->toArray();
        $cache->put($cacheKey, $laminations);

        return $laminations;
    }

    public function cuttings(bool $is_volume = false): array
    {
        return $this->calculator
            ->cuttings()
            ->wherePivot('is_volume', $is_volume)
            ->get()
            ?->toArray() ?? [];
    }

    /**
     * Формирование массива фольги на фронт
     * @param Calculator|null $calculator
     * @param bool|null $face
     * @return array
     */
    public function foilings(Calculator $calculator = null, bool $face = null): array
    {
        $cacheKey = cache_key('service:material:foilings', [
            'calculator_id' => $this->calculator->id,
            'calculator_sub_id' => $calculator?->id,
            'is_face' => $face,
            'is_calculator_sub' => $this->calculator instanceof CalculatorSub,
        ]);

        $cache = Cache::tags(['service', 'material', 'foilings']);

        if ($cache->has($cacheKey)) {
            return $cache->get($cacheKey);
        }

        $query = $this->calculator->foilings();

        if ($this->calculator instanceof CalculatorSub) {
            $query->wherePivot('calculator_id', $calculator->id);
        }

        if (!is_null($face)) {
            $query->wherePivot('is_face', $face);
        }

        $allTypes = [];
        $foilings['data'] =
            $query
                ->orderBy('sequence')
                ->with([
                    'specIcon',
                    'colors' => static function (BelongsToMany $query) {
                        $query->with(['image']);
                    },
                ])
                ->get()
                ->map(static function (Foiling $foiling) use (&$allTypes) {
                    $types = $foiling->colors->map(static function (FoilingColor $foilingColor) use (&$allTypes) {
                        $foilingColor['image'] = $foilingColor->image?->url ?? '';

                        if ($foilingColor['image']) {
                            $foilingColor['is_image'] = 0;
                        }

                        $allTypes[] = $foilingColor;
                        return $foilingColor;
                    });

                    $foiling->items = $types;

                    unset($foiling->colors);
                    return $foiling;
                })
                ->toArray() ?? [];

        $foilings['all_items'] = array_values(
            collect($allTypes)
                ->sortBy('sequence')
                ->unique('id')
                ->toArray(),
        );

        $cache->put($cacheKey, $foilings);
        return $foilings;
    }

    /**
     * Получение print_type
     * @return array
     */
    public function prints(): array
    {
        $cacheKey = cache_key('service:material:prints', [
            'calculator_id' => $this->calculator->id,
            'is_calculator_sub' => $this->calculator instanceof CalculatorSub,
        ]);

        $cache = Cache::tags(['service', 'material', 'prints']);

        if ($cache->has($cacheKey)) {
            return $cache->get($cacheKey);
        }

        $printTypes = $this->calculator->prints()->select('prints.id', 'prints.name');

        if ($this->calculator instanceof CalculatorSub) {
            $printTypes->wherePivot('calculator_id', $this->calculator->calculator->first()->id);
        }
        $printTypes = $printTypes?->get() ?? [];

        $printTypes = $printTypes->toArray() ?? [];

        $cache->put($cacheKey, $printTypes);
        return $printTypes;
    }

    /**
     * Возвращает сформированный массив цен на дизайн
     * @return array
     */
    public function designPrices(): array
    {
        $cacheKey = cache_key('service:material:designPrice', [
            'calculator_id' => $this->calculator->id,
            'calculator_type_id' => $this->calculator->calculatorType->id,
            'is_calculator_sub' => $this->calculator instanceof CalculatorSub,
        ]);

        $cache = Cache::tags(['service', 'material', 'designPrices']);

        if ($cache->has($cacheKey)) {
            return $cache->get($cacheKey);
        }

        $designPrices = $this->calculator
            ->calculatorType()
            ->first()
            ->designs()
            ->with(['prices'])
            ->first()?->prices;

        $prices =
            $designPrices
                ?->map(
                    fn ($item) => [
                        'id' => $item->id,
                        'label' => $item->name,
                        'value' => $item->value,
                    ],
                )
                ->toArray() ?? [];

        $cache->put($cacheKey, $prices);
        return $prices;
    }
}
