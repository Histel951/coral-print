<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\RapportKnife;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $ovalCalculator = Calculator::query()->where('name', 'Овальные этикетки в рулоне')->first();

        $complex = Calculator::query()->where('name', 'Фигурные этикетки в рулоне')->first();

        $modelTextEtiketki = [
            [
                'calculator' => Calculator::query()->where('name', 'Прямоугольные этикетки в рулоне')->first(),
                'fields' => [
                    'postText' => 'R=#radius# мм',
                    'name' => '#width#x#height# мм'
                ],
                'is_int' => true
            ],
            [
                'calculator' => $ovalCalculator,
                'fields' => [
                    'name' => '#width#x#height# мм'
                ],
                'is_int' => false
            ],
            [
                'calculator' => Calculator::query()->where('name', 'Прямоугольные этикетки в рулоне')->first(),
                'fields' => [
                    'postNameText' => ', углы ',
                ],
                'is_int' => false
            ],
            [
                'calculator' => Calculator::query()->where('name', 'Круглые этикетки в рулоне')->first(),
                'fields' => [
                    'name' => '#width# мм'
                ],
                'is_int' => false
            ],
            [
                'calculator' => $complex,
                'fields' => [
                    'prevText' => '«#description#», ',
                    'name' => '#width#x#height# мм'
                ],
                'is_int' => false
            ]
        ];

        foreach ($modelTextEtiketki as $item) {
            $this->setTextField($item['calculator'], $item['fields'], $item['is_int']);
        }

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height_flex' => [
                    'isNotUsePostTextIcon' => true
                ]
            ]
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_fields_config_id' => $config->getKey(),
            'calculator_id' => $ovalCalculator->id
        ]);

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height_flex' => [
                    'isNotUsePostTextIcon' => true
                ]
            ]
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_fields_config_id' => $config->getKey(),
            'calculator_id' => $complex->id
        ]);
    }

    private function setTextField(Calculator $calculator, array $fields, bool $isInt): void
    {
        foreach ($fields as $fieldName => $message) {
            $newModelTextData = $calculator->modelTextDataMessage()->create([
                'message' => $message,
                'model_class' => RapportKnife::class
            ]);

            $calculator->modelTextDataMessage()->updateExistingPivot($newModelTextData, [
                'model_field' => $fieldName,
                'is_int' => $isInt
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
