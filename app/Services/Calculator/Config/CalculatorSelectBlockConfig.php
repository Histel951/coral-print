<?php

namespace App\Services\Calculator\Config;

use App\Models\BlockSelectFieldConfig;
use App\Models\Calculator;
use Illuminate\Support\Collection;

class CalculatorSelectBlockConfig
{
    /**
     * @var Calculator
     */
    private Calculator $calculator;

    /**
     * Массив полей
     * @var array
     */
    private array $fields = [];

    /**
     * Массив чекбоксов
     * @var array
     */
    private array $checkboxes = [];

    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * Формирует массив конфигов для полей в зависимости от калькулятора
     * @return Collection
     */
    public function get(): Collection
    {
        return $this->calculator
            ->blockSelectField()
            ->with(['fields', 'calculatorSub', 'type'])
            ->get()
            ->map(function ($configFields): array {
                $this->findFieldsConfig($configFields);

                return [
                    'id' => $configFields->id,
                    'name' => $configFields->type->name,
                    'active' => false,
                    'fields' => collect($this->fields[$configFields->calculatorSub->name])->sortBy(['sequence']) ?? [],
                    'checkboxes' => $this->checkboxes[$configFields->calculatorSub->name] ?? [],
                ];
            });
    }

    /**
     * Скрипт формирует нужный массив конфигов для полей
     * @param BlockSelectFieldConfig $configFields
     * @return void
     */
    private function findFieldsConfig(BlockSelectFieldConfig $configFields): void
    {
        $configFields->fields->map(function ($field) use ($configFields) {
            $parameters = [
                ...$field->parameters,
                'type' => $field->type,
                'sequence' => $field->sequence,
                'id' => $field->id,
                'name' => $field->name,
            ];

            $dataKey = isset($field->parameters['formField']) ? 'formField' : 'dataField';

            $parameters[$dataKey] = $this->getDataKeyValue($configFields, $field->parameters[$dataKey]);

            if ($parameters['type'] != 'checkbox') {
                $this->fields[$configFields->calculatorSub->name][] = $parameters;
            } else {
                $this->checkboxes[$configFields->calculatorSub->name][] = $parameters;
            }
        });
    }

    /**
     * Формирует ключ для отсылки на объект с данными, в зависимости от того есть ли там уже разделение
     * по подкалькулятору
     * @param BlockSelectFieldConfig $configFields
     * @param string $dataKeyValue
     * @return string
     */
    private function getDataKeyValue(BlockSelectFieldConfig $configFields, string $dataKeyValue = ''): string
    {
        if (!preg_match("/_{$configFields->calculatorSub->name}/", $dataKeyValue)) {
            $dataKeyValue .= "_{$configFields->calculatorSub->name}";
        }

        return "{$dataKeyValue}_select";
    }
}
