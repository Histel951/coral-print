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

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
            'foiling_face' => [
                'conditions' => [
                    'blockingIdenticalValues' => [
                        [
                            'fields' => ['foiling_face', 'foiling_back'],
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
    public function down(): void
    {
        //
    }
};
