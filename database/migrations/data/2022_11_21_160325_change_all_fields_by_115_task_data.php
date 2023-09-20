<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\CalculatorType;
use App\Models\FormField;
use App\Models\FormFieldsSequence;
use App\Models\PivotCalculatorFieldsConfig;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Arr;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $productCount = FormField::query()->where('name', 'product_count')->first();
        $productCount->update([
            'parameters' => Arr::collapse([
                $productCount->parameters,
                [
                    'width' => 112
                ]
            ])
        ]);

        $calculators = CalculatorType::query()->where('name', 'stickers')->first()->calculators;

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'diameter' => [
                    'noneTopLine' => true
                ]
            ]
        ]);

        $calculators->each(fn (Calculator $calculator) => PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_fields_config_id' => $config->getKey()
        ]));

        $diameter = FormField::query()->where('name', 'diameter')->first();
        $diameter->update([
            'parameters' => Arr::collapse([
                $diameter->parameters,
                [
                    'width' => 96
                ]
            ])
        ]);

        $topLineNoneFieldConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height' => [
                    'noneTopLine' => true
                ]
            ]
        ]);

        $calculators = CalculatorType::query()->where('name', 'stickers')->first()->calculators;

        $calculators->each(fn (Calculator $calculator) => PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_fields_config_id' => $topLineNoneFieldConfig->getKey()
        ]));

        $widthHeightFieldLabel = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height' => [
                    'label' => 'Размер',
                    'labelInnerText' => '(↔✗↕)'
                ]
            ]
        ]);

        foreach ([3826, 3818] as $calculatorId) {
            PivotCalculatorFieldsConfig::query()->create([
                'calculator_id' => $calculatorId,
                'calculator_fields_config_id' => $widthHeightFieldLabel->getKey()
            ]);
        }

        $catalogBlocknotePapersField = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'page_count' => [
                    'label' => 'Листов',
                    'text_decoration' => false
                ]
            ]
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => 3859,
            'calculator_fields_config_id' => $catalogBlocknotePapersField->getKey()
        ]);

        $allCatalogs = CalculatorType::query()->with(['calculators' =>
            fn (HasMany $builder) => $builder->whereNot('id', 3859)
        ])->where('name', 'catalogs')->first()->calculators;

        $catalogPageCountField = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'page_count' => [
                    'text_decoration' => false
                ]
            ]
        ]);

        $allCatalogs->each(fn (Calculator $calculator) => PivotCalculatorFieldsConfig::query()->create([
            'calculator_fields_config_id' => $catalogPageCountField->getKey(),
            'calculator_id' => $calculator->id
        ]));

        $allBirki = CalculatorType::query()->where('name', 'labels')->first()->calculators;

        $allBirki->each(function (Calculator $calculator) {
            $fieldSequences = [
                'foiling_face' => 20,
                'hole' => 21,
            ];

            foreach ($fieldSequences as $fieldName => $sequence) {
                $field = FormField::query()->where('name', $fieldName)->first();

                FormFieldsSequence::query()->create([
                    'form_field_id' => $field->id,
                    'sequence' => $sequence,
                    'calculator_id' => $calculator->id
                ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        //
    }
};
