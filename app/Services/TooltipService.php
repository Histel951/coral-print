<?php

namespace App\Services;

use App\Models\Calculator;
use App\Models\CalculatorCheckboxConfig;
use App\Models\CalculatorFieldsConfig;
use App\Models\CalculatorType;
use App\Models\FormField;
use App\Services\Calculator\Config\CalculatorSelectBlockConfig;
use App\Services\Tooltip as TooltipI;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class TooltipService implements TooltipI
{
    public const TYPE_SHORT = 'short';
    public const TYPE_LONG = 'long';

    /**
     * @var Calculator
     */
    protected Calculator|null $calculator;

    public function __construct(Calculator $calculator = null)
    {
        $this->calculator = $calculator;
    }

    /**
     * @param int $status
     * @return string
     */
    public function getTypeText(string $type): string
    {
        $types = [
            self::TYPE_SHORT => 'Короткая',
            self::TYPE_LONG => 'Длинная',
        ];

        return $types[$type];
    }

    /**
     * @return string[]
     */
    public function getTypes(): array
    {
        return [
            self::TYPE_SHORT => 'Короткая',
            self::TYPE_LONG => 'Длинная',
        ];
    }

    public function getTooltips(): array
    {
        $tooltips = [];
        foreach ($this->calculator->calculatorType?->tooltips as $item) {
            $field = FormField::query()
                ->where('id', $item->field_id)
                ->get()
                ->first();
            $field &&
                ($tooltips[$field->name] = [
                    'name' => $field->name,
                    'header' => $item->name,
                    'type' => $item->type,
                    'content' => $item->content,
                ]);
        }

        return $tooltips;
    }

    /**
     * Возвращает поля по типу калькулятора, формирует массив id => name
     * @param CalculatorType $calculatorType
     * @return array
     */
    public function getFieldsToOptions(CalculatorType $calculatorType): array
    {
        $fields = [];
        $blockSelectFields = [];

        $calculatorType->calculators->each(function (Calculator $calculator) use (&$fields, &$blockSelectFields) {
            $formFields = FormField::query()
                ->whereIn(
                    'name',
                    $calculator
                        ->fields()
                        ->where('type', 'fields')
                        ->whereNot('type', '=', 'block_select')
                        ->first()?->value,
                )
                ->get();

            $formFields->each(function (FormField $field) use (&$fields) {
                $fields = $fields + [$field->id => $field->parameters['label'] ?? ''];
            });

            $checkboxes = $calculator->checkboxes?->first()?->value;

            if ($checkboxes) {
                $formCheckboxes = FormField::query()->whereIn('name', $checkboxes);
                $formCheckboxes->each(function (FormField $field) use (&$fields) {
                    $fields = $fields + [$field->id => $field->parameters['label'] ?? ''];
                });
            }

            $this->setBlockSelectFieldByCalculator($calculator, $blockSelectFields);
        });

        collect($blockSelectFields)
            ->map(function ($field) use (&$fields) {
                $label = $field['label'] ?? ($field['tooltip_field_name'] ?? '');
                $fields = $fields + [$field['id'] => "{$label}, $field[block_name]"];
            })
            ->toArray();

        ksort($fields);

        return $fields;
    }

    /**
     * Возвращает массив полей всех типов калькуляторов
     * @return array
     */
    public function getCalcTypesFormFields(): array
    {
        $result = [];
        $fields = CalculatorType::with([
            'calculators' => fn (HasMany $calculator) => $calculator->with([
                'fields' => fn (BelongsToMany $field) => $field->where('type', 'fields'),
                'checkboxes',
            ]),
        ]);

        $fields->each(function (CalculatorType $calculatorType) use (&$result) {
            $fieldNames = [];
            $blockSelectFields = [];

            $calculatorType->calculators->each(function (Calculator $calculator) use (
                &$fieldNames,
                &$blockSelectFields,
            ) {
                $this->setFieldsByCalculator($calculator, $fieldNames);
                $this->setBlockSelectFieldByCalculator($calculator, $blockSelectFields);
            });

            $result[$calculatorType->id] =
                $this->getCalcTypeFields($fieldNames) + $this->getBlockSelectCalcTypeFields($blockSelectFields);
        });

        return $result;
    }

    /**
     * Возвращает ID => "название" табов полей, в зависимости от переданных имён из FormField + данные сформированные
     * в getBlockSelectFieldByCalculator(), ключ - должен быть имя поля
     * @param array $fieldNames
     * @return array
     */
    private function getBlockSelectCalcTypeFields(array $fieldNames): array
    {
        $calcTypeField = [];
        $blockSelectFieldsQuery = FormField::query()->whereIn('name', array_unique(array_keys($fieldNames)));

        $blockSelectFieldsQuery->each(function (FormField $field) use ($fieldNames, &$calcTypeField) {
            if (isset($field->parameters['tooltip_field_name'])) {
                $calcTypeField[
                    $field->id
                ] = "{$field->parameters['tooltip_field_name']}, {$fieldNames[$field->name]['block_name']}";
            }

            if (isset($field->parameters['label']) && !isset($field->parameters['tooltip_field_name'])) {
                $calcTypeField[$field->id] = "{$field->parameters['label']}, {$fieldNames[$field->name]['block_name']}";
            }
        });

        return $calcTypeField;
    }

    /**
     * Возвращает ID => "название" полей, в зависимости от переданных имён из FormField
     * @param array $fieldNames
     * @return array
     */
    private function getCalcTypeFields(array $fieldNames): array
    {
        $fields = FormField::query()->whereIn('name', array_unique($fieldNames));

        $calcTypeField = [];
        $fields->each(function (FormField $field) use (&$result, &$calcTypeField): void {
            if (isset($field->parameters['tooltip_field_name'])) {
                $calcTypeField[$field->id] = $field->parameters['tooltip_field_name'];
            }

            if (isset($field->parameters['label']) && !isset($field->parameters['tooltip_field_name'])) {
                $calcTypeField[$field->id] = $field->parameters['label'];
            }
        });

        return $calcTypeField;
    }

    /**
     * Возвращает поля в зависимости от калькулятора
     * @param Calculator $calculator
     * @param $fieldNames
     * @return void
     */
    private function setFieldsByCalculator(Calculator $calculator, &$fieldNames): void
    {
        $fieldNames = [];
        $calculator->fields->each(function (CalculatorFieldsConfig $field) use (&$fieldNames) {
            $fieldNames = [...$fieldNames, ...$field->value];
        });

        $calculator->checkboxes->each(function (CalculatorCheckboxConfig $checkbox) use (&$fieldNames) {
            $fieldNames = [...$fieldNames, ...$checkbox->value];
        });
    }

    /**
     * Возвращает поля табов если они есть
     * @param Calculator $calculator
     * @param $blockSelectFields
     * @return void
     */
    private function setBlockSelectFieldByCalculator(Calculator $calculator, &$blockSelectFields): void
    {
        if ($calculator->blockSelectField()->count()) {
            $blockSelects = (new CalculatorSelectBlockConfig($calculator))->get();

            $blockSelects->each(function ($block) use (&$blockSelectFields) {
                $block['fields']->each(function (array $field) use ($block, &$blockSelectFields) {
                    $blockSelectFields[$field['name']] = [
                        'field' => $field['name'],
                        'block_name' => $block['name'],
                        ...$field,
                    ];
                });

                collect($block['checkboxes'])->each(function (array $field) use ($block, &$blockSelectFields) {
                    $blockSelectFields[$field['name']] = [
                        'field' => $field['name'],
                        'block_name' => $block['name'],
                        ...$field,
                    ];
                });
            });
        }
    }
}
