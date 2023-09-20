<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\CalculatorType;
use App\Models\PivotCalculatorFieldsConfig;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $allVisitkyCalculators = CalculatorType::query()
            ->where('name', 'businessCards')
            ->first()->calculators;

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height' => [
                    'conditions' => [
                        'hidden' => [
                            [
                                'field' => 'form',
                                'value' => 54
                            ],
                        ]
                    ]
                ],
                'diameter' => [
                    "conditions" => [
                        "visible" => [
                            [
                                "field" => "form",
                                "value" => 54
                            ]
                        ],
                    ]
                ]
            ]
        ]);

        $allVisitkyCalculators->each(function (Calculator $calculator) use ($config) {
            PivotCalculatorFieldsConfig::query()->create([
                'calculator_id' => $calculator->id,
                'calculator_fields_config_id' => $config->getKey()
            ]);
        });

        $businessCardsFieldsConfigs = DB::select('
            select * from pivot_calculator_fields_configs pcfc
            left join calculator_fields_configs cfc on (pcfc.calculator_fields_config_id = cfc.id)
            left join calculators on (pcfc.calculator_id = calculators.id)
            left join calculator_types on (calculators.calculator_type_id = calculator_types.id)
             where calculator_id and cfc.type = \'fields\' and calculator_types.name = \'businessCards\';');

        foreach ($businessCardsFieldsConfigs as $fieldsConfig) {
            $calculatorFieldsConfig = CalculatorFieldsConfig::query()->find($fieldsConfig->calculator_fields_config_id);

            $value = $calculatorFieldsConfig->value;
            if (!in_array('diameter', $value)) {
                $value[] = 'diameter';
                $calculatorFieldsConfig->update([
                    'value' => array_values($value)
                ]);
            }
        }


        CalculatorFieldsConfig::query()->find(34)->update([
            'value' => json_decode('{"width_height": {"label": "Размер в развороте", "labelInnerText": ""}}', true)
        ]);
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
