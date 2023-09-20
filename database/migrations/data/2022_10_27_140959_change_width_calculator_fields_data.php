<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\CalculatorType;
use App\Models\PivotCalculatorFieldsConfig;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $allCalculatorStickers = CalculatorType::query()->where('name', 'stickers')
            ->first()->calculators;

        $allCalculatorBooklets = CalculatorType::query()->where('name', 'booklets')
            ->first()->calculators;

        $allCalculatorCatalogs = CalculatorType::query()->where('name', 'catalogs')
            ->first()->calculators;

        $allCalculatorLabels = CalculatorType::query()->where('name', 'labels')
            ->first()->calculators;

        $newDiameterStickersConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'diameter' => [
                    'width' => 96
                ]
            ]
        ]);

        $newWidthHeightStickersConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height' => [
                    'width' => 64
                ]
            ]
        ]);

        $allCalculatorStickers->each(fn (Calculator $calculator) => PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_fields_config_id' => $newDiameterStickersConfig->getKey()
        ]));

        $allCalculatorStickers->each(fn (Calculator $calculator) => PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_fields_config_id' => $newWidthHeightStickersConfig->getKey()
        ]));

        $allBusinessCardCalculators = CalculatorType::query()->where('name', 'businessCards')
            ->first()->calculators;

        $newProductCountTypesConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'product_count_types' => [
                    'width' => 112
                ]
            ]
        ]);

        $newProductCountConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'product_count' => [
                    'width' => 112
                ]
            ]
        ]);

        $newEditionCountConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'edition_count' => [
                    'width' => 112
                ]
            ]
        ]);

        $allBusinessCardCalculators->each(fn (Calculator $calculator) => PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_fields_config_id' => $newProductCountTypesConfig->getKey()
        ]));

        $allCalculatorBooklets->each(fn (Calculator $calculator) => PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_fields_config_id' => $newProductCountConfig->getKey()
        ]));

        $allCalculatorCatalogs->each(fn (Calculator $calculator) => PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_fields_config_id' => $newEditionCountConfig->getKey()
        ]));

        $allCalculatorLabels->each(fn (Calculator $calculator) => PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_fields_config_id' => $newProductCountConfig->getKey()
        ]));

        $calculatorIdsFieldsChange = [3833, 3836];

        foreach ($calculatorIdsFieldsChange as $calculatorId) {
            // product_count_types
            PivotCalculatorFieldsConfig::query()->where('calculator_id', $calculatorId)->each(
                function (PivotCalculatorFieldsConfig $pivotCalculatorFieldsConfig) {
                    $config = CalculatorFieldsConfig::query()->find($pivotCalculatorFieldsConfig->calculator_fields_config_id);

                    if ($config?->type === 'fields') {
                        $config->update([
                            'value' => ["width_height", "product_count_types", "material", "material_wrapper"]
                        ]);
                    }
                }
            );
        }

        $newProductCountStickersConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'product_count_types' => [
                    'width' => 96
                ]
            ]
        ]);

        $allCalculatorStickers->each(fn (Calculator $calculator) => PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_fields_config_id' => $newProductCountStickersConfig->getKey()
        ]));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
