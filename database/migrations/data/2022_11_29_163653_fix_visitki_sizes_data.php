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
        $calculatorsVisitki = CalculatorType::query()
            ->where('name', 'businessCards')
            ->first()
            ->calculators;

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height' => [
                    'predefinedValues' => true
                ]
            ]
        ]);

        $calculatorsVisitki->each(function (Calculator $calculator) use ($config): void {
            PivotCalculatorFieldsConfig::query()->create([
                'calculator_id' => $calculator->id,
                'calculator_fields_config_id' => $config->getKey()
            ]);
        });
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
