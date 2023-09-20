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
        $calculatorProductCountIds = [];

        $calculatorCatalogs = CalculatorType::query()->where('name', 'catalogs')->first()->calculators;
        $lastCalculator = CalculatorType::query()->where('name', 'catalogs')
            ->first()->calculators()->orderBy('id', 'desc')->first();

        $calculatorCatalogs->each(function (Calculator $calculator) use (&$calculatorProductCountIds, $lastCalculator) {
            if ($lastCalculator->id !== $calculator->id) {
                $calculatorProductCountIds[] = $calculator->id;
            }
        });

        $this->setNoneTopLineFieldOption($calculatorProductCountIds);
        $this->setNoneTopLineFieldOption([$lastCalculator->id]);
    }

    private function setNoneTopLineFieldOption(array $calculatorIds): void
    {
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
    public function down(): void
    {
        //
    }
};
