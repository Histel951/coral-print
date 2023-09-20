<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\ColorCount;
use App\Models\FormField;
use App\Models\PivotCalculatorColorCount;
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
        $vipBooklet = Calculator::query()->find(3873);

        PivotCalculatorFieldsConfig::query()->where('calculator_id', $vipBooklet->id)->each(
            function (PivotCalculatorFieldsConfig $pivotCalculatorFieldsConfig) {
                $config = CalculatorFieldsConfig::query()->where('id', $pivotCalculatorFieldsConfig->calculator_fields_config_id)->first();

                if ($config->type === 'fields') {
                    $config->delete();
                }
            }
        );

        FormField::query()->create([
            'name' => 'fold_count',
            'type' => 'select',
            'parameters' => json_decode('{"label": "Сложение", "dataField": "fold_count", "defaultId": 1, "formField": "fold_count"}', true)
        ]);

        $fieldsConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'fields',
            'value' => ['width_height', 'fold_count', 'product_count', 'print_select', 'lam', 'material']
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $vipBooklet->id,
            'calculator_fields_config_id' => $fieldsConfig->getKey()
        ]);

        $folds = [
            [
                'name' => '1 сгиб',
                'value' => 1
            ],
            [
                'name' => '2 сгиба',
                'value' => 2
            ],
            [
                'name' => '3 сгиба',
                'value' => 3
            ],
            [
                'name' => '4 сгиба',
                'value' => 4
            ],
            [
                'name' => '5 сгибов',
                'value' => 5
            ]
        ];

        foreach ($folds as $fold) {
            $newFold = ColorCount::query()->create([
                'name' => $fold['name'],
                'value' => $fold['value']
            ]);

            PivotCalculatorColorCount::query()->create([
                'calculator_id' => $vipBooklet->id,
                'color_count_id' => $newFold->getKey()
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
