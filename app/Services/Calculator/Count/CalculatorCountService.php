<?php

declare(strict_types=1);

namespace App\Services\Calculator\Count;

use App\Models\Calculator;
use App\Services\Calculator\CalculatorType;
use Illuminate\Contracts\Container\BindingResolutionException;

class CalculatorCountService
{
    /**
     * Передаваемый калькулятор для подтягивания данных
     * @var Calculator
     */
    private readonly Calculator $calculator;

    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * @return CalculatorCount
     * @throws BindingResolutionException
     */
    public function __invoke(): CalculatorCount
    {
        $typeName = $this->calculator->calculatorType->name;

        if ($this->calculator->calculatedCalculatorType) {
            $typeName = $this->calculator->calculatedCalculatorType->name;
        }

        return $this->getInstanceByTypeName(CalculatorType::from($typeName));
    }

    /**
     * Возвращает подсчёт калькулятора в зависимости от типа
     * @param CalculatorType $calculatorType
     * @return CalculatorCount
     * @throws BindingResolutionException
     */
    private function getInstanceByTypeName(CalculatorType $calculatorType): CalculatorCount
    {
        return match ($calculatorType) {
            CalculatorType::Stickers => new StickersCountService($this->calculator),
            CalculatorType::Catalogs => new CatalogCountService($this->calculator),
            CalculatorType::BusinessCards => new BusinessCardCountService($this->calculator),
            CalculatorType::Booklets => new BookletsCountService($this->calculator),
            CalculatorType::Labels => new LabelsCountService($this->calculator),
            CalculatorType::labelsTag => new TagLabelCount($this->calculator),
        };
    }
}
