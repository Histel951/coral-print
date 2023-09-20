<?php

use App\Models\Calculator;
use App\Models\CalculatorCheckboxConfig;
use App\Models\CalculatorFieldsConfig;
use App\Models\Foiling;
use App\Models\FormField;
use App\Models\FormFieldsSequence;
use App\Models\PivotCalculatorCheckboxConfig;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\PivotCalculatorFoiling;
use App\Models\PivotWorkAdditional;
use App\Models\PrintSize;
use App\Models\WorkAdditional;
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
        $calculator = Calculator::query()->where('name', 'VIP Буклет')->first();

        $a5 = PrintSize::query()->create([
            'name' => 'А5 (210х148 мм)',
            'short_name' => '210х148',
            'height' => 148,
            'width' => 210
        ]);

        $a4 = PrintSize::query()->create([
            'name' => 'А4 (297х210 мм)',
            'short_name' => '297х210',
            'height' => 210,
            'width' => 297
        ]);

        $a3 = PrintSize::query()->create([
            'name' => 'А3 (420х297 мм)',
            'short_name' => '420х297',
            'height' => 297,
            'width' => 420
        ]);

        $this->setPrintSizes($calculator, [$a5->getKey(), $a4->getKey(), $a3->getKey()]);
        $this->changeFieldsList($calculator, ["width_height", "fold_count", "product_count", "lam", "material", 'foiling']);
        $this->changeWidthHeightField($calculator);
        $this->changeSequenceFields($calculator);
        $this->addFoilings($calculator);
        $this->addFoilingWorkAdditionals($calculator);
        $this->addCheckboxes($calculator);
        $this->addVarnishWorkAdditionals($calculator);
        $this->setReadonlyConditions($calculator);
    }

    /**
     * @param Calculator|Model $calculator
     * @return void
     */
    private function setReadonlyConditions(Calculator|Model $calculator): void
    {
        // сделать возможность для 'value' => [материал ИЛИ материал]
//        $newConfig = CalculatorFieldsConfig::query()->create([
//            'type' => 'fields_options',
//            'value' => [
//                'lam' => [
//                    'conditions' => [
//                        'readonlyItemsIn' => [
//                            [
//                                'disabled_items' => [26, 27, 28, 29, 30, 78, 79, 80, 81, 82, 83, 84, 85, 86],
//                                'values' => [123],
//                                'change_field' => 'material',
//                                'field' => 'lam'
//                            ]
//                        ]
//                    ]
//                ]
//            ]
//        ]);
//
//        PivotCalculatorFieldsConfig::query()->create([
//            'calculator_id' => $calculator->id,
//            'calculator_fields_config_id' => $newConfig->getKey()
//        ]);
    }

    /**
     * @param Calculator|Model $calculator
     * @return void
     */
    private function addVarnishWorkAdditionals(Calculator|Model $calculator): void
    {
        $workAdditionalsVarnish = WorkAdditional::query()->whereIn('code', ['#лак', '#приллак']);

        $workAdditionalsVarnish->each(
            fn (WorkAdditional $workAdditional) => PivotWorkAdditional::query()->create([
                'work_additional_id' => $workAdditional->getKey(),
                'is_varnish_face' => 1,
                'calculator_id' => $calculator->id
            ])
        );

        $workAdditionalsVarnish->each(
            fn (WorkAdditional $workAdditional) => PivotWorkAdditional::query()->create([
                'work_additional_id' => $workAdditional->getKey(),
                'is_varnish_back' => 1,
                'calculator_id' => $calculator->id
            ])
        );
    }

    /**
     * @param Calculator|Model $calculator
     * @return void
     */
    private function addCheckboxes(Calculator|Model $calculator): void
    {
        $config = CalculatorCheckboxConfig::query()->create([
            'value' => ['varnish_face', 'varnish_back']
        ]);

        PivotCalculatorCheckboxConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_checkbox_config_id' => $config->getKey()
        ]);
    }

    /**
     * @param Calculator|Model $calculator
     * @return void
     */
    private function addFoilingWorkAdditionals(Calculator|Model $calculator): void
    {
        $prilFoiling = WorkAdditional::query()->where('code', '#прилфольга')->first();
        $foilingSpech = WorkAdditional::query()->where('code', '#фольгаспеч')->first();

        foreach ([$prilFoiling, $foilingSpech] as $work) {
            PivotWorkAdditional::query()->create([
                'work_additional_id' => $work->getKey(),
                'foiling_id' => 27,
                'calculator_id' => $calculator->id
            ]);
        }
    }

    /**
     * @param Calculator|Model $calculator
     * @return void
     */
    private function addFoilings(Calculator|Model $calculator): void
    {
        $foilings = Calculator::query()->find(3821)->foilings;

        $foilings->each(fn (Foiling $foiling) => PivotCalculatorFoiling::query()->create([
            'foiling_id' => $foiling->id,
            'calculator_id' => $calculator->id
        ]));
    }

    /**
     * @param Calculator|Model $calculator
     * @return void
     */
    private function changeSequenceFields(Calculator|Model $calculator): void
    {
        $fieldsSequence = [
            'width_height' => 1,
            'product_count' => 2,
            'material' => 3,
            'lam' => 4,
            'fold_count' => 5,
            'foiling' => 6
        ];

        foreach ($fieldsSequence as $fieldName => $sequence) {
            $formField = FormField::query()->where('name', $fieldName)->first();

            FormFieldsSequence::query()
                ->where('calculator_id', $calculator->id)
                ->where('form_field_id', $formField->id)
                ->delete();

            FormFieldsSequence::query()->create([
                'calculator_id' => $calculator->id,
                'form_field_id' => $formField->id,
                'sequence' => $sequence
            ]);
        }
    }

    /**
     * @param Calculator|Model $calculator
     * @return void
     */
    private function changeWidthHeightField(Calculator|Model $calculator): void
    {
        $widthHeightConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height' => [
                    'predefinedValues' => true,
                    'label' => 'Размер в развороте'
                ]
            ]
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_fields_config_id' => $widthHeightConfig->getKey()
        ]);
    }

    /**
     * @param Calculator|Model $calculator
     * @param string[] $fields
     * @return void
     */
    private function changeFieldsList(Calculator|Model $calculator, array $fields = []): void
    {
        $calculator->fieldsConfig()->where('type', 'fields')->update([
            'value' => $fields
        ]);
    }

    /**
     * @param Calculator|Model $calculator
     * @param int[] $sizesIds
     * @return void
     */
    private function setPrintSizes(Calculator|Model $calculator, array $sizesIds): void
    {
        $calculator->printSizes()->delete();

        $calculator->printSizes()->sync($sizesIds);
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
