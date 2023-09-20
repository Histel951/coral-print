<?php

namespace App\Services\Calculator;

use App\Models\Calculator;
use App\Models\FormField;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Traits\Macroable;

class CalculatorFieldService implements FieldsService
{
    use Macroable;

    /**
     * @var Calculator
     */
    protected Calculator $calculator;

    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * Возвращают сформированный массив конфигов для полей
     * @return array
     */
    public function fields(): array
    {
        $cacheKey = cache_key('service:fields:fields', [
            'calculator_id' => $this->calculator->id,
        ]);

        return Cache::tags(['service', 'fields', 'fields'])->remember($cacheKey, now()->addDays(2), function (): array {
            $fields = $this->getFields();
            $fieldsOptions = $this->getFieldsOption();

            return collect($this->getConfigFields($fields, $fieldsOptions))
                ->sortBy(['sequence'])
                ->toArray();
        });
    }

    /**
     * Возвращают сформированный массив конфигов для чекбоксов
     * @return array
     */
    public function checkboxes(): array
    {
        $cacheKey = cache_key('service:fields:checkboxes', [
            'calculator_id' => $this->calculator->id,
        ]);

        return Cache::tags(['service', 'fields', 'checkboxes'])->remember(
            $cacheKey,
            now()->addDays(2),
            function (): array {
                $checkboxes = $this->getCheckboxes();
                $checkboxesOptions = $this->getCheckboxesOptions();

                return $this->getConfigFields($checkboxes, $checkboxesOptions);
            },
        );
    }

    /**
     * Получение массива полей калькулятора
     * @return array
     */
    protected function getFields(): array
    {
        return $this->calculator
            ->fields()
            ?->where('type', 'fields')
            ->first()->value ?? [];
    }

    /**
     * Получение массива чекбоксов калькулятора
     * @return array
     */
    protected function getCheckboxes(): array
    {
        return $this->calculator->checkboxes()?->first()->value ?? [];
    }

    /**
     * Получение и формирование конфига, для полей калькулятора
     * @return array
     */
    protected function getFieldsOption(): array
    {
        $fieldsOption = $this->calculator
            ->fieldsConfig()
            ->where('type', 'fields_options')
            ->get();
        $resultOptions = $fieldsOption->shift()?->value ?? [];

        $fieldsConfig = new CalculatorFieldsFormatter($resultOptions);

        return $fieldsConfig->get($fieldsOption);
    }

    /**
     * Получение и формирование конфига, для чекбоксов калькулятора
     * @return array
     */
    protected function getCheckboxesOptions(): array
    {
        $checkboxesOptions = $this->calculator
            ->fieldsConfig()
            ->where('type', 'checkboxes_options')
            ->get();
        $resultOptions = $checkboxesOptions->shift()?->value ?? [];

        $fieldsConfig = new CalculatorFieldsFormatter($resultOptions);
        return $fieldsConfig->get($checkboxesOptions);
    }

    /**
     * Формирует общий конфиг для переданных полей под vue
     * @param array $fields - поля калькулятора $this->fields || $this->checkboxes
     * @param array $fieldsConfig - конфиги конкретных полей
     * калькулятора $this->fieldsOption || $this->checkboxesOptions
     * @return array
     */
    protected function getConfigFields(array $fields, array $fieldsConfig = []): array
    {
        $allFieldsTypes = FormField::all()->mapToGroups(function (FormField $field): array {
            $sequence = $field
                ->sequenceField()
                ->where('calculator_id', $this->calculator->id)
                ->first()?->sequence;

            if (!$sequence) {
                $sequence = $field->sequence;
            }

            return [
                $field->name => [
                    'type' => $field->type,
                    'sequence' => $sequence,
                    'id' => $field->id,
                    'name' => $field->name,
                    ...$field->parameters,
                ],
            ];
        });

        return Arr::map($fields, static function ($field) use ($allFieldsTypes, $fieldsConfig) {
            if (array_key_exists($field, $fieldsConfig)) {
                if (isset($fieldsConfig[$field]) and isset($allFieldsTypes[$field])) {
                    return array_merge(
                        $allFieldsTypes[$field]->toArray()[0],
                        collect($fieldsConfig[$field])->toArray(),
                    );
                }
            }

            return $allFieldsTypes[$field]->toArray()[0];
        });
    }
}
