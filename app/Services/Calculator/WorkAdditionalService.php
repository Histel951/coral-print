<?php

namespace App\Services\Calculator;

use App\Models\PivotWorkAdditional;
use App\Services\Calculator\Count\Algorithms\Calculator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Traits\Macroable;
use Closure;

/**
 * Устанавливает доп. работы для переданного подсчётного калькулятора
 * phpcs:ignore
 * @method static void setCalculatorWorks(Calculator &$calculator, array $whereParams = [], int $times = null, float $coefficient = 1)
 */
class WorkAdditionalService
{
    use Macroable;

    public function __construct()
    {
    }

    /**
     * Поля не учавствующие в построении where запроса
     * @var string[]
     */
    protected array $notFindFields = ['id', 'work_additional_id', 'created_at', 'updated_at', 'repeat'];

    /**
     * Промежуточная модель много ко многим для доп работ
     * @var string
     */
    protected string $pivotWorkAdditionalModel = PivotWorkAdditional::class;

    /**
     * Устанавливает доп работы
     * @param Calculator $calculator
     * @param array $whereParameters
     * @param int|null $times
     * @param int $coefficient
     * @return void
     */
    protected function setWorks(
        Calculator $calculator,
        array $whereParameters,
        int $times = null,
        int $coefficient = 1,
    ): void {
        $workAdditionals = $this->findWorks($whereParameters);

        if (!$workAdditionals->count()) {
            return;
        }

        $works = $this->groupWorks($workAdditionals, $times);

        $works->map(function (array|null $work) use (&$calculator, $coefficient) {
            if ($work) {
                $calculator->setAddJob($work['id'], $work['times'], $coefficient);
            }
        });
    }

    /**
     * Поиск доп работ по параметрам ['fieldName' => value]
     * Если параметр не передан то value => null
     * @param string[] $whereParams
     * @param $environment - область видимости для вызова callback
     * @return Collection
     */
    protected function findWorks(array $whereParams = [], $environment = null): Collection
    {
        $cacheKey = cache_key('work_additionals:find', $whereParams);

        $cache = Cache::tags(['workAdditional', 'service', 'find']);

        if ($cache->has($cacheKey)) {
            return collect(json_decode($cache->get($cacheKey)));
        }

        $modelFields = Schema::getColumnListing((new $this->pivotWorkAdditionalModel())->getTable());

        foreach ($this->notFindFields as $field) {
            unset($modelFields[array_search($field, $modelFields)]);
        }

        $additionalWorks = PivotWorkAdditional::with(['workAdditional']);

        foreach ($modelFields as $field) {
            if (key_exists($field, $whereParams)) {
                $this->chooseFindWorkExpression($additionalWorks, $field, $whereParams[$field], $environment);
            } else {
                $additionalWorks->whereNull($field);
            }
        }

        $works = $additionalWorks->get();
        $cache->put($cacheKey, $works->toJson());

        return $additionalWorks->get();
    }

    /**
     * Формирует массив и подсчитывает некоторые данные для передачи в функцию сета доп работ
     * @param Collection $workAdditionals
     * @param int|null $times
     * @return Collection
     */
    private function groupWorks(Collection $workAdditionals, int $times = null): Collection
    {
        return $workAdditionals->map(static function (object $work) use ($times) {
            if (!$work->work_additional) {
                return;
            }

            if (!$times) {
                $times = $work->repeat;

                if ($work->work_additional?->times > 1) {
                    $times += (int) $work->workAdditional?->times;
                }
            }

            return [
                'id' => $work->work_additional->id,
                'times' => $times ?? 1,
            ];
        });
    }

    /**
     * Выбирает тривиальное условие если в value переданно определённое значение
     * @param Builder $additionalWorkBuilder
     * @param string $field
     * @param mixed $value - можно передать callback(Builder $additionalWorkBuilder)
     * @param $environment
     * @return void
     */
    private function chooseFindWorkExpression(
        Builder $additionalWorkBuilder,
        string $field,
        mixed $value,
        $environment,
    ): void {
        if ($value instanceof Closure) {
            $value->call($environment ?? $this, $additionalWorkBuilder);

            return;
        }

        if (is_iterable($value)) {
            $additionalWorkBuilder->whereIn($field, $value);

            return;
        }

        match ($value) {
            ':notNull:', ':not_null:', ':not null:' => $additionalWorkBuilder->whereNotNull($field),
            default => $additionalWorkBuilder->where($field, $value),
        };
    }
}
