<?php

namespace App\Services\Calculator\Config;

use App\Models\Calculator;
use App\Services\Calculator\CalculatorType;
use Illuminate\Contracts\Container\BindingResolutionException;

class CalculatorConfigService
{
    private Calculator $calculator;

    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * Возвращает объект конфигов калькуляторов в зависимости от его типа
     * @return CalculatorConfigInterface
     * @throws BindingResolutionException
     */
    public function __invoke(): CalculatorConfigInterface
    {
        return match (CalculatorType::from(
            $this->calculator->calculatedCalculatorType?->name
                ?? $this->calculator->calculatorType?->name
        )) {
            CalculatorType::Stickers => new CalculatorStickersConfig($this->calculator),
            CalculatorType::BusinessCards => new CalculatorBusinessCardConfig($this->calculator),
            CalculatorType::Catalogs => new CalculatorCatalogConfig($this->calculator),
            CalculatorType::Booklets => new CalculatorBookletConfig($this->calculator),
            CalculatorType::Labels => new CalculatorLabelsConfig($this->calculator),
            CalculatorType::labelsTag => new CalculatorTagLabelConfig($this->calculator),
        };
    }
}
