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
        $calculators = [3832];

        $newConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'material' => [
                    'conditions' => [
                        'readonlyItemsIn' => [
                            [
                                'disabled_items' => [86],
                                'values' => [27],
                                'change_field' => 'material',
                                'field' => 'foiling_face',
                                'value' => 46
                            ],
                            [
                                'disabled_items' => [86],
                                'values' => [27],
                                'change_field' => 'material',
                                'field' => 'foiling_back',
                                'value' => 46
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        foreach ($calculators as $calculatorId) {
            PivotCalculatorFieldsConfig::query()->create([
                'calculator_id' => $calculatorId,
                'calculator_fields_config_id' => $newConfig->getKey()
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
