<?php

namespace App\Services\Calculator;

use App\Models\Calculator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Traits\Macroable;

/**
 * Формирует общий массив роутов для всех калькуляторов
 * @package CalculatorRouteService
 */
class CalculatorRouteService implements CalculatorRoute
{
    use Macroable;

    /**
     * @var Calculator
     */
    private Calculator $calculator;

    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * Формирует массив стандартный массив роутов
     * @param array $designPrices
     * @return array
     */
    public function getRoutes(array $designPrices = []): array
    {
        return [
            'mainImg' => [
                'url' => route('calculator.preview', [
                    'calculator' => $this->calculator->id,
                ]),
                'props' => [
                    'deps' => $this->getProps('deps'),
                ],
            ],
            'count' => [
                'url' => route('calculator.count', [
                    'calculator' => $this->calculator->id,
                    'type' => $this->calculator->id,
                    'calc_category_id' => $this->calculator->id,
                ]),
            ],
            'mockupsUpload' => [
                'url' => '',
                'services' => [
                    'design' => $designPrices,
                ],
            ],
            'discounts' => [
                'url' => '',
            ],
        ];
    }

    /**
     * Возвращает значение свойства роута
     * @param string $name
     * @return array
     */
    public function getProps(string $name): array
    {
        $cacheKey = cache_key('service:route:getProps', [
            'calculator_id' => $this->calculator->id,
        ]);

        return Cache::tags(['service', 'route', 'getProps'])->remember(
            $cacheKey,
            now()->addDays(2),
            fn () => $this->calculator
                ->routeProps()
                ->where('calculator_route_props.name', $name)
                ->first()?->value ?? [],
        );
    }
}
