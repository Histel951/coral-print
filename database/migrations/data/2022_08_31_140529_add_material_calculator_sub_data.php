<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\PivotCalculatorMaterial;
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
        PivotCalculatorMaterial::query()->whereIn('calculator_sub_id', [1, 2, 3])->delete();

        $materialCatalogs = [
            [
                'calculators' => [3855, 3856, 3858, 3859, 3860],
                'calculator_sub' => 1,
                'materials' => [26, 27, 28, 29, 30, 43, 44, 45, 46, 78, 79, 80, 81, 144, 82, 143, 83, 84, 85, 86, 87, 88, 89]
            ],
            [
                'calculators' => [3855, 3856, 3858],
                'calculator_sub' => 2,
                'materials' => [26, 27, 28, 29, 30, 43, 44, 45, 46]
            ],
            [
                'calculators' => [3859, 3860],
                'calculator_sub' => 2,
                'materials' => [26, 27, 29, 30]
            ],
            [
                'calculators' => [3866],
                'calculator_sub' => 1,
                'materials' => [90, 37, 40]
            ]
        ];

        foreach ($materialCatalogs as $materialCatalog) {
            foreach ($materialCatalog['calculators'] as $calculatorId) {
                foreach ($materialCatalog['materials'] as $materialId) {
                    PivotCalculatorMaterial::query()->create([
                        'calculator_sub_id' => $materialCatalog['calculator_sub'],
                        'calculator_id' => $calculatorId,
                        'material_id' => $materialId
                    ]);
                }
            }
        }

        $newConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'material_wrapper' => [
                    'conditions' => [
                        'readonlyIn' => [
                            [
                                'change_field' => 'lam_cover_select',
                                'field' => 'material_cover_select',
                                'values' => [26,27,28,29,30, 78, 79, 80, 81, 144, 82, 143, 83, 84, 85, 86, 87, 88, 89],
                                'value' => 111
                            ]
                        ],
                        'readonlyItemsIn' => [
                            [
                                'disabled_items' => [26,27,28,29,30, 78, 79, 80, 81, 144, 82, 143, 83, 84, 85, 86, 87, 88, 89],
                                'values' => [112, 113, 114, 115, 116, 117],
                                'change_field' => 'material_cover_select',
                                'field' => 'lam_cover_select',
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
