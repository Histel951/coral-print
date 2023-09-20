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
        $calculators = CalculatorType::query()->where('name', 'booklets')->first()->calculators;

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'fold_count' => [
                    'isUseValue' => true
                ]
            ]
        ]);

        $calculators->each(fn (Calculator $calculator) => PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_fields_config_id' => $config->getKey()
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
