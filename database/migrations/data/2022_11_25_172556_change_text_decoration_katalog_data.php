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
        $calculators = CalculatorType::query()->where('name', 'catalogs')->first()->calculators;

        $configPageCount = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'page_select' => [
                    'text_decoration' => false
                ]
            ]
        ]);

        $configPageCountSheets = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'page_count_sheets' => [
                    'text_decoration' => false
                ]
            ]
        ]);

        $calculators->each(function (Calculator $calculator) use ($configPageCount, $configPageCountSheets) {
            PivotCalculatorFieldsConfig::query()->create([
                'calculator_id' => $calculator->id,
                'calculator_fields_config_id' => $configPageCount->getKey()
            ]);

            PivotCalculatorFieldsConfig::query()->create([
                'calculator_id' => $calculator->id,
                'calculator_fields_config_id' => $configPageCountSheets->getKey()
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
