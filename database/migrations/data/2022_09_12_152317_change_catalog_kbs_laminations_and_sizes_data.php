<?php

use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\FormField;
use App\Models\PivotCalculatorBlockSelectFields;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\PivotCalculatorLamination;
use App\Models\PivotCalculatorPrintSize;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        PivotCalculatorLamination::query()
            ->where('calculator_id', 3866)
            ->where('calculator_sub_id', 1)
            ->whereIn('lamination_id', [113, 115, 117])
            ->delete();

        $calculatorBoltsSizes = PivotCalculatorPrintSize::query()->where('calculator_id', 3866);

        $calculator = Calculator::query()
            ->where('name', 'Брошюры на болтах')
            ->where('calculator_type_id', 3854)
            ->first();

        $calculatorBoltsSizes->each(
            fn (PivotCalculatorPrintSize $pivotCalculatorPrintSize) => PivotCalculatorPrintSize::query()->create([
                'calculator_id' => $calculator->id,
                'print_size_id' => $pivotCalculatorPrintSize->print_size_id
            ])
        );

        $widthHeightOption = CalculatorFieldsConfig::query()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height' => [
                    'predefinedValues' => true,
                    'labelInnerText' => ''
                ],
            ]
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_fields_config_id' => $widthHeightOption->getKey()
        ]);

        $calculator->update([
            'parameters' => [
                'is_wide' => true,
                'is_adhesive' => true,
                'is_two_side_print' => true
            ]
        ]);

        $allMaterialFields = [68, 25, 27, 26];

        foreach ($allMaterialFields as $materialFieldId) {
            $materialField = FormField::query()->find($materialFieldId);

            $materialFieldValue = $materialField->parameters;
            $materialFieldValue['label'] = 'Бумага';

            $materialField->update([
                'sequence' => 2,
                'parameters' => $materialFieldValue
            ]);
        }

        $allLaminationFields = [31, 32];

        foreach ($allLaminationFields as $laminationFieldId) {
            FormField::query()->find($laminationFieldId)->update([
                'sequence' => 3
            ]);
        }

        $allFoilingFields = [49, 50, 51];

        foreach ($allFoilingFields as $foilingFieldId) {
            FormField::query()->find($foilingFieldId)->update([
                'sequence' => 4
            ]);
        }

        $plasticSubstrate = FormField::query()->find(33);
        $plasticSubstrateParameters = $plasticSubstrate->parameters;
        $plasticSubstrateParameters['label'] = 'Пластик';

        $plasticSubstrate->update([
            'parameters' => $plasticSubstrateParameters
        ]);

        PivotCalculatorBlockSelectFields::query()->create([
            'form_field_id' => 35,
            'block_select_field_config_id' => 8
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
