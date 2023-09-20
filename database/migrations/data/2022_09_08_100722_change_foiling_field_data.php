<?php

use App\Models\CalculatorFieldsConfig;
use App\Models\FormField;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $foilingField = FormField::query()->find(49);
        $parameters = $foilingField->parameters;
        $parameters['formMaterialField'] = 'foiling_cover_select';

        $foilingField->update([
            'parameters' => $parameters
        ]);

        $newConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'material_wrapper' => [
                    'conditions' => [
                        'readonlyIn' => [
                            [
                                'change_field' => 'lam_cover_select',
                                'field' => 'foiling_cover_select',
                                'values' => [26, 27],
                                'value' => 116
                            ]
                        ],
                        'unReadOnlyItemsIn' => [
                            [
                                'change_field' => 'material_cover_select',
                                'field' => 'foiling_cover_select',
                                'values' => [86],
                                'value' => 26
                            ]
                        ]
                    ],
                ]
            ]
        ]);

        $allCatalogCalculatorsIds = \App\Models\Calculator::query()->where('calculator_type_id', 3854)->pluck('id');

        $allCatalogCalculatorsIds->map(fn (int $calculatorId): \Illuminate\Database\Eloquent\Model => \App\Models\PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculatorId,
            'calculator_fields_config_id' => $newConfig->getKey()
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
