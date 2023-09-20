<?php

use App\Models\Calculator;
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
        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height_flex' => [
                    'isNotUsePostNameIcon' => true,
                    'isNotUsePostNameText' => true
                ]
            ]
        ]);

        $calculator = Calculator::query()->where('name', 'Овальные этикетки в рулоне')->first();

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_fields_config_id' => $config->getKey()
        ]);
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
