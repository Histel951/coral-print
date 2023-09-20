<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Models\Color;
use App\Models\PrintForm;
use App\Models\RapportKnife;
use App\Models\WindingCategory;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculatorTypeTagLabel = CalculatorType::query()->where('name', 'labelsTag')->first();

        $calculatorSilverGoldComplex = $calculatorTypeTagLabel->calculators()->create([
            'name' => 'Серебрянные и золотистые этикетки',
            'description' => 'Серебрянные и золотистые этикетки',
            'min_price' => 30,
            'active' => true,
            'svg_id' => 'complex-labels-gold-silver',
            'print_form_id' => PrintForm::query()->where('name', 'Круглая')->first()->id
        ]);

        $calculatorSilverGoldComplex->materials()->sync([28, 29]);
        $calculatorSilverGoldComplex->forms()->sync(PrintForm::query()->whereIn('name', [
            'Круглая',
            'Прямоугольная',
            'Овальная',
            'Сложная'
        ])->pluck('id'));

        $calculatorSilverGoldComplex->colors()->attach(
            Color::query()->where('name', 'Полноцвет+белым')->first()->id
        );

        $calculatorSilverGoldComplex->fields()->create([
            'type' => 'fields',
            'value' => ['form', "width_height_flex", "product_count_types", "material_select", "color_paints", "location"]
        ]);

        $calculatorSilverGoldComplex->windingCategories()->sync(WindingCategory::all()->pluck('id'));

        Calculator::query()
            ->where('calculator_type_id', CalculatorType::query()->where('name', 'labelsTag')->first()->id)
            ->whereNull('calculated_calculator_type_id')->update([
                'parameters' => [
                    'is_knifes' => true
                ]
            ]);

        $modelTextEtiketki = [
            [
                'print_form_id' => PrintForm::query()->where('name', 'Прямоугольная')->first()->id,
                'fields' => [
                    'postText' => 'R=#radius# мм',
                    'name' => '#width#x#height# мм'
                ],
                'is_int' => true
            ],
            [
                'print_form_id' => PrintForm::query()->where('name', 'Овальная')->first()->id,
                'fields' => [
                    'name' => '#width#x#height# мм'
                ],
                'is_int' => false
            ],
            [
                'print_form_id' => PrintForm::query()->where('name', 'Прямоугольная')->first()->id,
                'fields' => [
                    'postNameText' => ', углы ',
                ],
                'is_int' => false
            ],
            [
                'print_form_id' => PrintForm::query()->where('name', 'Круглая')->first()->id,
                'fields' => [
                    'name' => '#width# мм'
                ],
                'is_int' => false
            ],
            [
                'print_form_id' => PrintForm::query()->where('name', 'Сложная')->first()->id,
                'fields' => [
                    'prevText' => '«#description#», ',
                    'name' => '#width#x#height# мм'
                ],
                'is_int' => false
            ]
        ];

        foreach ($modelTextEtiketki as $item) {
            $this->setTextField($calculatorSilverGoldComplex, $item['fields'], $item['is_int'], $item['print_form_id']);
        }
    }

    private function setTextField(Calculator $calculator, array $fields, bool $isInt, int $printFormId): void
    {
        foreach ($fields as $fieldName => $message) {
            $newModelTextData = $calculator->modelTextDataMessage()->create([
                'message' => $message,
                'model_class' => RapportKnife::class
            ]);

            $calculator->modelTextDataMessage()->updateExistingPivot($newModelTextData, [
                'model_field' => $fieldName,
                'is_int' => $isInt,
                'print_form_id' => $printFormId
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
