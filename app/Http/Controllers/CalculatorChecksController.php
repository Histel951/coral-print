<?php

namespace App\Http\Controllers;

use App\Models\Calculator;
use App\Services\Calculator\CalculatorFrequent;
use App\Services\Calculator\CalculatorServiceException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CalculatorChecksController extends Controller
{
    use CalculatorFrequent;

    /**
     * Проверяет равны ли переданные значения $values с значениями из базы
     * @param Calculator $calculator
     * @param Request $request
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws CalculatorServiceException
     */
    public function checkEqualOr(Calculator $calculator, Request $request): JsonResponse
    {
        $checkService = $this->calculatorService($calculator)->check();

        return $this->jsonResultResponse(
            result: !$checkService->equalOr(fieldName: $request->get('field'), depsValues: $request->get('values')),
        );
    }

    /**
     * @param Calculator $calculator
     * @param Request $request
     * @return JsonResponse
     * @throws BindingResolutionException
     * @throws CalculatorServiceException
     */
    public function checkEqualOrAndData(Calculator $calculator, Request $request): JsonResponse
    {
        $checkService = $this->calculatorService($calculator)->check();

        $check = $checkService->equalOrAndData(fieldName: $request->get('field'), depsValues: $request->get('values'));

        $check['result'] = !$check['result'];

        return response()->json($check);
    }

    /**
     * Общий ответ для этого контроллера
     * @param array $result
     * @return JsonResponse
     */
    private function jsonResultResponse(mixed $result): JsonResponse
    {
        return response()->json([
            'result' => $result,
        ]);
    }
}
