<?php

use App\Models\CalculatorFieldsConfig;
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
        $calculators = [3820, 3824];

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'checkboxes_options',
            'value' => ['complex_form' => [
                'conditions' => [
                    'readonly' => [
                        [
                            'field' => 'cutting',
                            'value' => 5
                        ]
                    ],
                    'unchecked' => [
                        [
                            'field' => 'cutting',
                            'value' => 5
                        ]
                    ]
                ]
            ]]
        ]);

        foreach ($calculators as $calculatorId) {
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
