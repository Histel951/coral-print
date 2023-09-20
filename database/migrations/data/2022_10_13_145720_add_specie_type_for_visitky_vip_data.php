<?php

use App\Models\CalculatorCheckboxConfig;
use App\Models\CalculatorFieldsConfig;
use App\Models\PivotCalculatorCheckboxConfig;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\PivotCalculatorSpecieType;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculators = [3833, 3836];

        foreach ($calculators as $calculatorId) {
            $specieType = PivotCalculatorSpecieType::query()
                ->where('calculator_id', $calculatorId)
                ->where('specie_type_id', 45)
                ->first();

            if (!$specieType) {
                PivotCalculatorSpecieType::query()->create([
                    'calculator_id' => $calculatorId,
                    'specie_type_id' => 45,
                    'print_id' => 0
                ]);
            }
        }

        $calculatorsForCheckbox = [3832];

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'checkboxes_options',
            'value' => [
                'rounding_corners' => [
                    'conditions' => [
                        'readonly' => [
                            [
                                'field' => 'form',
                                'value' => [54, 56, 57]
                            ]
                        ],
                        'unchecked' => [
                            [
                                'field' => 'form',
                                'value' => [54, 56, 57]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        foreach ($calculatorsForCheckbox as $calculatorId) {
            $newCheckboxConfig = CalculatorCheckboxConfig::query()->create([
                'value' => ['rounding_corners']
            ]);

            PivotCalculatorCheckboxConfig::query()->create([
                'calculator_id' => $calculatorId,
                'calculator_checkbox_config_id' => $newCheckboxConfig->getKey()
            ]);

            PivotCalculatorFieldsConfig::query()->create([
                'calculator_id' => $calculatorId,
                'calculator_fields_config_id' => $config->getKey()
            ]);
        }
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
