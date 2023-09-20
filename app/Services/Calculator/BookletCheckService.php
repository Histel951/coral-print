<?php

namespace App\Services\Calculator;

use App\Models\Calculator;
use App\Models\Check;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Находит нужную проверку от текущего типа калькулятора
 * @package BookletCheckService
 */
class BookletCheckService implements CalculatorCheckService
{
    /**
     * Общий сервис проверки
     * @var ChecksService|mixed
     */
    private ChecksService $checksService;

    /**
     * Сервис калькуляторов
     * @var CalculatorService|mixed
     */
    private CalculatorService $calculatorService;

    /**
     * @throws BindingResolutionException
     */
    public function __construct(private readonly Calculator $calculator)
    {
        $this->checksService = app()->make(ChecksService::class);
        $this->calculatorService = app()->make(CalculatorService::class, [
            'calculator' => $this->calculator,
        ]);
    }

    /**
     * Находит проверку от текущего калькулятора и переданным параметрам
     * @param string $fieldName
     * @param array $depsValues
     * @return bool
     */
    public function equalOr(string $fieldName, array $depsValues): bool
    {
        try {
            $check = $this->getCheck($fieldName, $depsValues);
        } catch (CalculatorCheckException) {
            return true;
        }

        return $this->checksService->equalOr(check: $check, values: $depsValues);
    }

    /**
     * Проверяет равны ли переданные значения $values с значениями из базы
     * Возвращает результат + данные для проверки
     * @param string $fieldName
     * @param array $depsValues
     * @return array
     */
    public function equalOrAndData(string $fieldName, array $depsValues): array
    {
        try {
            $check = $this->getCheck($fieldName, $depsValues);
        } catch (CalculatorCheckException) {
            return [
                'result' => true,
                'checks' => [],
            ];
        }

        $result = $this->checksService->equalOr(check: $check, values: $depsValues);

        return [
            'result' => $result,
            'checks' => $check->checks,
            'identifiers' => $check->identifiers,
            'data' => $check->data,
        ];
    }

    /**
     * Возвращает проверку
     * @param string $fieldName
     * @param array $depsValues
     * @return Check
     * @throws CalculatorCheckException
     */
    private function getCheck(string $fieldName, array $depsValues): Check
    {
        $materialService = $this->calculatorService->material();

        $specieType = $materialService->specieType(
            width: (int) $depsValues['width'],
            height: (int) $depsValues['height'],
            colorId: isset($depsValues['print_select']) ? (int) $depsValues['print_select'] : null,
        );

        if (!$specieType) {
            throw new CalculatorCheckException("Don't found specie type for check.");
        }

        $jsonContains = [
            'print_specie_id' => $specieType->print_specie_id,
        ];

        if (isset($depsValues['lam'])) {
            $jsonContains['lam'] = (int) $depsValues['lam'];
        }

        $check = $this->calculator->checks()->where('name', $fieldName);

        foreach ($jsonContains as $key => $value) {
            $check->whereJsonContains('identifiers', [$key => $value]);
        }

        $check = $check->first();

        if (!$check) {
            throw new CalculatorCheckException("Don't found check.");
        }

        return $check;
    }
}
