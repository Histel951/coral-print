<?php

namespace App\Services\Calculator;

use App\Models\CalculatorFieldsConfig as CalculatorFieldsConfigModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class CalculatorFieldsFormatter
{
    private array $resultConfigs;

    public function __construct(array $resultConfigs = [])
    {
        $this->resultConfigs = $resultConfigs;
    }

    /**
     * Формирует конфиг для конкретных полей калькулятора
     * @param Collection $configs
     * @return array
     */
    public function get(Collection $configs): array
    {
        if (!$configs->count()) {
            return $this->resultConfigs;
        }

        $configs->map(function (CalculatorFieldsConfigModel $fieldConfig) {
            foreach ($fieldConfig->value as $field => $fieldValues) {
                if (is_iterable($fieldValues)) {
                    foreach ($fieldValues as $key => $value) {
                        if ($key === 'conditions') {
                            foreach ($value as $conditionKey => $condition) {
                                if (isset($this->resultConfigs[$field][$key][$conditionKey])) {
                                    $this->resultConfigs[$field][$key][$conditionKey] = Arr::collapse([
                                        $this->resultConfigs[$field][$key][$conditionKey],
                                        $condition,
                                    ]);
                                } else {
                                    $this->resultConfigs[$field][$key][$conditionKey] = $condition;
                                }
                            }
                        } else {
                            if (
                                isset($this->resultConfigs[$field][$key]) and
                                is_array($this->resultConfigs[$field][$key])
                            ) {
                                $this->resultConfigs[$field][$key] = Arr::collapse([
                                    $this->resultConfigs[$field][$key],
                                    $value,
                                ]);
                            } else {
                                $this->resultConfigs[$field][$key] = $value;
                            }
                        }
                    }
                } else {
                    $this->resultConfigs[$field] = $fieldValues;
                }
            }
        });

        return $this->resultConfigs;
    }
}
