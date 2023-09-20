<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculatorConfigsByIdsRequest;
use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Models\PrintForm;
use App\Repositories\Knifes\RapportKnifeRepositoryInterface;
use App\Services\Calculator\CalculatorFrequent;
use App\Services\Calculator\PreviewService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class CalculatorController extends Controller
{
    use CalculatorFrequent;

    /**
     * Возвращает все калькуляторы, если передать 1 калькулятор, то он выведется на страницу, при
     * передаче в параметры типа, выведутся все и переданный калькулятор станет активным
     * @param Calculator $calculator
     * @param CalculatorType|null $calculatorType
     * @return JsonResponse
     */
    public function types(Calculator $calculator, CalculatorType $calculatorType = null): JsonResponse
    {
        $cacheKey = cache_key(
            'calculator:controller:types',
            is_null($calculatorType)
                ? ['calculator_id' => $calculator->id]
                : ['calculator_type_id' => $calculatorType->id],
        );

        $cache = Cache::tags(['calculator', 'controller', 'types']);

        if ($cache->has($cacheKey)) {
            return response()->json($cache->get($cacheKey));
        }

        if (!is_null($calculatorType)) {
            $result = $calculatorType
                ->calculators()
                ->orderBy('sequence')
                ->active()
                ->get()
                ->map(
                    fn (Calculator $eachCalculator): array => $this->pullOutCalculatorData(
                        $eachCalculator,
                        $calculator->id == $eachCalculator->id,
                    ),
                );
        }

        $result = $result ?? [$calculator];
        $cache->put($cacheKey, $result, now()->addDays(2));

        return response()->json($result);
    }

    /**
     * Возвращает все ламинации в зависимости от калькулятора и print_id(type)
     * @param Request $request
     * @param Calculator $calculator
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function laminations(Request $request, Calculator $calculator): JsonResponse
    {
        return response()->json(
            $this->calculatorService($calculator)
                ->material()
                ->laminations($request->all()),
        );
    }

    /**
     * Возвращает нарезки в зависимости от ID калькулятора
     * @param Request $request
     * @param Calculator $calculator
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function cuttings(Request $request, Calculator $calculator): JsonResponse
    {
        return response()->json(
            $this->calculatorService($calculator)
                ->material()
                ->cuttings((bool) (int) $request->get('volume', false)),
        );
    }

    /**
     * Возвращает сформированный массив материалов от переданного калькулятора и print_id(type)
     * @param Calculator $calculator
     * @param Request $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function materials(Calculator $calculator, Request $request): JsonResponse
    {
        return response()->json(
            $this->calculatorService($calculator)
                ->material()
                ->materials($request->all()),
        );
    }

    /**
     * Возвращает URI на картинку, в зависимости от калькулятора
     * @param Request $request
     * @param Calculator $calculator
     * @param PreviewService $previewService сервис для подтягивания превью
     * @return JsonResponse
     */
    public function preview(Request $request, Calculator $calculator, PreviewService $previewService): JsonResponse
    {
        $previews = $previewService->get($calculator, [
            'calculator_type_id' => $calculator->calculatorType?->id,
            'calculator_id' => $calculator->id,
            'cutting_id' => $request->get('cutting', 0),
            'form_id' => $request->get('form', 0),
            'is_volume' => (bool) (int) $request->get('volume', 0),
            'is_mounting_film' => (bool) (int) $request->get('mounting_film', 0),
        ]);

        return response()->json($previews);
    }

    /**
     * Возвращает конфиги калькулятора
     * @param Request $request
     * @param Calculator $calculator
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function config(Request $request, Calculator $calculator): JsonResponse
    {
        return response()->json(
            Arr::collapse([
                $this->calculatorService($calculator)
                    ->config()
                    ->get([
                        'print_type' => $request->query('print_type'),
                    ]),
                [
                    'page' => $calculator->page,
                ],
            ]),
        );
    }

    /**
     * Подсчитывает стоимость печати
     * @param Calculator $calculator
     * @param Request $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function count(Calculator $calculator, Request $request): JsonResponse
    {
        return response()->json(
            $this->calculatorService($calculator)
                ->count()
                ->get($request->all()),
        );
    }

    /**
     * Возвращает скидки калькулятора
     * @param Calculator $calculator
     * @param Request $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function discount(Calculator $calculator, Request $request): JsonResponse
    {
        $discountData = $this->calculatorService($calculator)
            ->count()
            ->get([...$request->all(), 'discount' => true]);

        return response()->json([
            'discounts' => $discountData['discounts'],
            'discount_min_edition' => $discountData['discount_min_edition'],
        ]);
    }

    /**
     * Цены на дизайн
     * @param Calculator $calculator
     * @return JsonResponse
     */
    public function prices(Calculator $calculator): JsonResponse
    {
        return response()->json([
            'prices' => $calculator->calculatorType->designs
                ->map(fn ($v) => $v->prices)
                ->collapse()
                ->sortBy('sort')
                ->values()
                ->toArray(),
        ]);
    }

    /**
     * Возвращает коллекцию ножей калькулятора
     * @param Calculator $calculator
     * @param Request $request
     * @param RapportKnifeRepositoryInterface $knifeRepository
     * @return JsonResponse
     */
    public function knifes(Calculator $calculator, Request $request, RapportKnifeRepositoryInterface $knifeRepository): JsonResponse
    {
        return response()->json($knifeRepository->knifes(
            calculator: $calculator,
            printForm: PrintForm::find($request->get('form')) ?? $calculator->printForm
        ));
    }

    /**
     * @param CalculatorConfigsByIdsRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function configsByIds(CalculatorConfigsByIdsRequest $request): JsonResponse
    {
        $calculators = $request->get('calculators');
        $configs = $this->calculatorService(null)->configsByIds($calculators);

        return response()->json([
            'calculators' => $configs,
        ]);
    }

    /**
     * Вытягивает из калькулятора и формирует массив нужных для возврата в типах калькуляторов
     * @param Calculator $calculator
     * @param bool $active
     * @return array
     */
    private function pullOutCalculatorData(Calculator $calculator, bool $active = false): array
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
            'active' => $active,
            'category' => $calculator->name,
            'svg_id' => $calculator->svg_id,
        ];
    }
}
