<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\CalculatorType;
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
        $calculators = Calculator::query()->whereIn('name', [
            'Стикеры с печатью белым',
            'Объемные наклейки',
            'Гарантийные стикеры'
        ]);

        $widthHeightNoneLine = CalculatorFieldsConfig::query()->whereJsonContains('value', [
            'width_height' => [
                'noneTopLine' => true
            ]
        ])->first();

        $diameterNoneLine = CalculatorFieldsConfig::query()->whereJsonContains('value', [
            'diameter' => [
                'noneTopLine' => true
            ]
        ])->first();

        $calculators->each(fn (Calculator $calculator) => $this->setSequence($calculator, [
            'form' => 1,
            'diameter' => 2,
            'width_height' => 3,
            'product_count_types' => 4,
            'material' => 5,
            'lam' => 6,
            'foiling' => 7,
            'cutting' => 8
        ]));

        $calculatorsDetachNoneTopLine = $calculators->whereIn('name', [
            'Стикеры с печатью белым',
            'Наклейки с фольгой',
            'Объемные наклейки',
            'Гарантийные стикеры',
        ]);

        $calculatorsDetachNoneTopLine->each(fn (Calculator $calculator) => $calculator->fields()->detach($widthHeightNoneLine->id));
        $calculatorsDetachNoneTopLine->each(fn (Calculator $calculator) => $calculator->fields()->detach($diameterNoneLine->id));

        $calculatorBooklets = CalculatorType::query()->where('name', 'booklets')->first()->calculators;

        $vipBooklet = $calculatorBooklets->where('name', 'VIP Буклет')->first();

        $vipBooklet->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'foiling' => [
                    'label' => 'Фольга, 1+0'
                ]
            ]
        ]);
    }

    private function setSequence(Calculator $calculator, array $fieldsSequence): void
    {
        $calculator->fieldsSequence()->delete();
        foreach ($fieldsSequence as $fieldName => $sequence) {
            $field = FormField::query()->where('name', $fieldName)->first();

            $calculator->fieldsSequence()->create([
                'form_field_id' => $field->id,
                'sequence' => $sequence
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
