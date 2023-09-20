<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\PivotCalculatorFieldsConfig;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $newConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'material_wrapper' => [
                    'conditions' => [
                        'readonlyIn' => [
                            [
                                'change_field' => 'lam_substrate_select',
                                'field' => 'material_substrate_select',
                                'values' => [26,27,28,29,30, 78, 79, 80, 81, 144, 82, 143, 83, 84, 85, 86, 87, 88, 89],
                                'value' => 111
                            ]
                        ],
                        'readonlyItemsIn' => [
                            [
                                'disabled_items' => [26,27,28,29,30, 78, 79, 80, 81, 144, 82, 143, 83, 84, 85, 86, 87, 88, 89],
                                'values' => [112, 113, 114, 115, 116, 117],
                                'change_field' => 'material_substrate_select',
                                'field' => 'lam_substrate_select',
                                'value' => 43
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $allCatalogCalculatorsIds = Calculator::query()->where('calculator_type_id', 3854)->pluck('id');

        $allCatalogCalculatorsIds->map(fn (int $calculatorId): Model => PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculatorId,
            'calculator_fields_config_id' => $newConfig->getKey()
        ]));
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
