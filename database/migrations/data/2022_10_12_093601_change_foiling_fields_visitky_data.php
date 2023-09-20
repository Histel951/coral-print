<?php

use App\Models\CalculatorFieldsConfig;
use App\Models\FormField;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\PivotCalculatorMaterial;
use App\Models\PivotCalculatorPrints;
use App\Models\PrintModel;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $fields = CalculatorFieldsConfig::query()->find(29)->value;

        $key = array_search('foiling_back', $fields);
        unset($fields[$key]);

        CalculatorFieldsConfig::query()->find(29)->update([
            'value' => array_values($fields)
        ]);

        $newParameters = json_decode('{"info": false, "label": "Фольга лицо", "postText": "", "dataField": "foiling_face", "formField": "foiling_face", "formColorField": "foiling_face_color", "labelInnerText": "", "labelModalLink": "foiling_face-modal", "formMaterialField": "foiling_face"}', true);

        $newParameters['label'] = 'Фольга, 1+0';
        FormField::query()->find(37)->update([
            'parameters' => $newParameters
        ]);

        PivotCalculatorFieldsConfig::query()
            ->where('calculator_id', 3832)
            ->where('calculator_fields_config_id', 71)
            ?->delete();

        $newPrints = [
            'Цветная, с одной стороны' => 96,
            'Цветная, с двух сторон' => 96
        ];

        PivotCalculatorPrints::query()->where('calculator_id', 3832)->delete();
        foreach ($newPrints as $name => $printTypeId) {
            $newPrint = PrintModel::query()->create([
                'name' => $name,
                'print_type_id' => $printTypeId
            ]);

            PivotCalculatorPrints::query()->create([
                'calculator_id' => 3832,
                'print_id' => $newPrint->getKey()
            ]);
        }

        PivotCalculatorMaterial::query()->where('calculator_id', 3832)?->delete();

        PivotCalculatorPrints::query()
            ->where('calculator_id', 3832)
            ->each(function (PivotCalculatorPrints $calculatorPrints) {
                foreach ([46, 86] as $materialId) {
                    PivotCalculatorMaterial::query()->create([
                        'calculator_id' => 3832,
                        'print_id' => $calculatorPrints->print_id,
                        'material_id' => $materialId
                    ]);
                }
            });

        $calculators = [3832];

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'print_type_select' => [
                    'conditions' => [
                        'readonly' => [
                            [
                                'field' => 'foiling_face',
                                'value' => 26,
                                'selected_value' => PivotCalculatorPrints::query()
                                    ->where('calculator_id', 3832)
                                    ->first()->print_id
                            ]
                        ],
                        'selected' => [
                            [
                                'field' => 'foiling_face',
                                'value' => 26,
                                'selected_value' => PivotCalculatorPrints::query()
                                    ->where('calculator_id', 3832)
                                    ->first()->print_id
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        foreach ($calculators as $calculatorId) {
            PivotCalculatorFieldsConfig::query()->create([
                'calculator_id' => $calculatorId,
                'calculator_fields_config_id' => $config->getKey()
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
