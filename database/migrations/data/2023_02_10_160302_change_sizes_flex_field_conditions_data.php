<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\CalculatorType;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\PrintForm;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculators = CalculatorType::query()->where('name', \App\Services\Calculator\CalculatorType::labelsTag->value)
            ->first()->calculators->whereIn('name', [
                'На прозрачной плёнке с белым',
                'Этикетки с персонализацией',
                'Термоэтикетка'
            ]);

        $calculators->each(fn (Calculator $calculator) => $this->setConditions($calculator));
    }

    private function setConditions(Calculator $calculator): void
    {
        $roundFormId = PrintForm::query()->where('name', 'Круглая')->first()->id;
        $complexFormId = PrintForm::query()->where('name', 'Сложная')->first()->id;

        $config = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height_flex' => [
                    'conditions' => [
                        'labelFormChange' => [
                            [
                                'values' => [
                                    'form' => [
                                        $roundFormId => 'Диаметр',
                                        $complexFormId => 'Вид и размер'
                                    ]
                                ],
                                'default' => 'Размер'
                            ]
                        ]
                    ],
                    'url' => route('calculator.knifes'),
                    'deps' => ['form']
                ]
            ]
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_fields_config_id' => $config->getKey(),
            'calculator_id' => $calculator->id
        ]);
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
