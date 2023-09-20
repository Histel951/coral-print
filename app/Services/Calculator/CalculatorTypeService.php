<?php

namespace App\Services\Calculator;

use App\Models\Calculator;
use App\Models\CalculatorType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CalculatorTypeService
{
    public function __construct(
        private readonly Calculator $calculator,
        private readonly ?CalculatorType $calculatorType,
    ) {
    }

    public function __invoke()
    {
        $parameters =
            null === $this->calculatorType
                ? ['calculator_id' => $this->calculator->id]
                : ['calculator_type_id' => $this->calculatorType->id];
        $cacheKey = cache_key('calculator:controller:types', $parameters);
        $cache = Cache::tags(['calculator', 'controller', 'types']);

        if ($cache->has($cacheKey)) {
            return $cache->get($cacheKey);
        }

        if (null !== $this->calculatorType) {
            $result = $this->calculatorType
                ->calculators()
                ->orderBy('sequence')
                ->active()
                ->get()
                ->map(fn (Calculator $calculator): array => $this->prepare($calculator));
        }

        $result = $result ?? [$this->calculator];
        $result = $result instanceof Collection ? $result->toArray() : $result;

        $cache->put($cacheKey, $result, now()->addDays(2));

        return $result;
    }

    /**
     * Вытягивает из калькулятора и формирует массив нужных для возврата в типах калькуляторов
     *
     * @param Calculator $calculator
     *
     * @return array
     */
    private function prepare(Calculator $calculator): array
    {
        return [
            'id' => $calculator->id,
            'value' => transliterate($calculator->name),
            'image' => $calculator->image?->url(),
            'pagetitle' => $calculator->name,
            'min_price' => $calculator->min_price,
            'url' => route('calculator.config', [
                'calculator' => $calculator->id,
            ]),
            'active' => $this->calculator->id == $calculator->id,
            'category' => $calculator->name,
            'svg_id' => $calculator->svg_id,
            'show_print_type' => $this->calculatorType->show_print_type,
        ];
    }
}
