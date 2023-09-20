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
        $calculatorIds = [3836, 3833];

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'material_wrapper' => [
                    'noneTopLine' => true
                ],
            ],
        ]);

        foreach ($calculatorIds as $calculatorId) {
            PivotCalculatorFieldsConfig::query()->create([
                'calculator_fields_config_id' => $config->getKey(),
                'calculator_id' => $calculatorId
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
