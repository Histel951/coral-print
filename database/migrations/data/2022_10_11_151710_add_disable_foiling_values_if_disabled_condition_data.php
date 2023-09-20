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
        PivotCalculatorFieldsConfig::query()->where('calculator_id', 3832)->where('calculator_fields_config_id', 69)?->delete();

        $calculators = [3832];

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'foiling_face' => [
                    'conditions' => [
                        'disabledIfValue' => [
                            [
                                'dependence_field' => 'foiling_back',
                                'if_value' => 26,
                                'dependence_value' => 27
                            ]
                        ]
                    ]
                ]
            ]
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
