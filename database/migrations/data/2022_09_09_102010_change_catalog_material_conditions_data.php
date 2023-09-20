<?php

use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $newConfig = \App\Models\CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'material_wrapper' => [
                    'conditions' => [
                        'readonlyIn' => [
                            [
                                'change_field' => 'color_cover_select',
                                'field' => 'foiling_cover_select',
                                'values' => [26, 27],
                                'value' => 10
                            ]
                        ],
                        'selected' => [
                            [
                                'field' => 'material_cover_select',
                                'value' => 86,
                                'change_field' => 'lam_cover_select',
                                'selected_value' => 111
                            ]
                        ],
                        'readonlyItemsIn' => [
                            [
                                'disabled_items' => [26,27,28,29,30, 78, 79, 80, 81, 144, 82, 143, 83, 84, 85, 86, 87, 88, 89],
                                'values' => [26,27],
                                'change_field' => 'material_cover_select',
                                'field' => 'foiling_cover_select',
                                'value' => 43,
                                'sequence' => 2,
                                'block' => 'cover'
                            ],
                            [
                                'disabled_items' => [26,27,28,29,30, 78, 79, 80, 81, 144, 82, 143, 83, 84, 85, 86, 87, 88, 89],
                                'values' => [112, 113, 114, 115, 116, 117],
                                'change_field' => 'material_cover_select',
                                'field' => 'lam_cover_select',
                                'value' => 43,
                                'block' => 'cover'
                            ],
                            [
                                'disabled_items' => [26,27,28,29,30, 78, 79, 80, 81, 144, 82, 143, 83, 84, 85, 86, 87, 88, 89],
                                'values' => [112, 113, 114, 115, 116, 117],
                                'change_field' => 'material_cover_select',
                                'field' => 'lam_cover_select',
                                'value' => 43,
                                'block' => 'cover'
                            ]
                        ],
                        'selectedAnd' => [
                            [
                                'field_values' => ['foiling_cover_select' => 26, 'material_cover_select' => [43, 44, 45, 46]],
                                'value' => 116,
                                'change_field' => 'lam_cover_select'
                            ]
                        ],
                    ]
                ]
            ]
        ]);

        $allCatalogCalculatorsIds = \App\Models\Calculator::query()->where('calculator_type_id', 3854)->pluck('id');

        $allCatalogCalculatorsIds->map(function (int $calculatorId) use ($newConfig) {
            \App\Models\PivotCalculatorFieldsConfig::query()
                ->where('calculator_id', $calculatorId)
                ->whereIn('calculator_fields_config_id', [51, 52])
                ->delete();

            \App\Models\PivotCalculatorFieldsConfig::query()->create([
                'calculator_id' => $calculatorId,
                'calculator_fields_config_id' => $newConfig->getKey()
            ]);
        });

        $newConfig = \App\Models\CalculatorFieldsConfig::query()->create([
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
                            ],
                            [
                                'field' => 'material_cover_select',
                                'value' => 111,
                                'values' =>  [26, 27, 28, 29, 30, 78, 79, 80, 81, 144, 82, 143, 83, 84, 85, 86, 87, 88, 89],
                                'change_field' => 'lam_cover_select'
                            ],
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
                                'value' => 43,
                                'block' => 'substrate'
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $allCatalogCalculatorsIds->map(function (int $calculatorId) use ($newConfig) {
            \App\Models\PivotCalculatorFieldsConfig::query()->create([
                'calculator_id' => $calculatorId,
                'calculator_fields_config_id' => $newConfig->getKey()
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
