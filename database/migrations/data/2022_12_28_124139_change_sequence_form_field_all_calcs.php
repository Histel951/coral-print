<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Models\FormField;
use App\Models\Lamination;
use App\Models\PivotCalculatorLamination;
use App\Models\PivotWorkAdditional;
use App\Models\WorkAdditional;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $businessCardType = CalculatorType::query()->where('name', 'businessCards')->first();
        $foilingBusinessCard = $businessCardType->calculators
            ->where('name', 'С фольгированием')->first();

        $fieldSequence = [
            'form' => 1,
            'width_height' => 2,
            'diameter' => 3,
            'product_count_types' => 4,
            'print_type_select' => 5,
            'material' => 6,
            'foiling_face' => 7
        ];

        $foilingBusinessCard->fieldsSequence()->delete();
        foreach ($fieldSequence as $fieldName => $sequence) {
            $field = FormField::query()->where('name', $fieldName)->first();

            $foilingBusinessCard->fieldsSequence()->create([
                'form_field_id' => $field->id,
                'sequence' => $sequence
            ]);
        }

        $springsCalculators = CalculatorType::query()->where('name', 'catalogs')->first()->calculators
            ->whereIn('name', ['Презентации', 'Блокноты']);

        $fieldSequenceSprings = [
            'width_height' => 1,
            'tooltip_print' => 2,
            'sprint_position' => 3,
            'page_count' => 4,
            'product_count' => 5
        ];

        $springsCalculators->each(fn (Calculator $calculator) => $calculator->fieldsSequence()->delete());
        foreach ($fieldSequenceSprings as $fieldName => $sequence) {
            $springsCalculators->each(function (Calculator $calculator) use ($fieldName, $sequence) {
                $field = FormField::query()->where('name', $fieldName)->first();

                $calculator->fieldsSequence()->create([
                    'form_field_id' => $field->id,
                    'sequence' => $sequence
                ]);
            });
        }

        $this->changeListsFoilings(Calculator::query()->where('name', 'На листах с фольгой')->first(), 17);

        $labelTagType = CalculatorType::query()->where('name', \App\Services\Calculator\CalculatorType::labelsTag->value)->first();
        $complexLabelTag = $labelTagType->calculators->where('name', 'Фигурные этикетки')->first();
        $complexFormWorkAdditional = WorkAdditional::query()->where('code', '#сложформ')->first();

        PivotWorkAdditional::query()->create([
            'work_additional_id' => $complexFormWorkAdditional->id,
            'calculator_id' => $complexLabelTag->id
        ]);

        $fieldSequenceSprings = [
            'form' => 1,
            'width_height' => 2,
            'diameter' => 3,
            'product_count_types' => 4,
            'material' => 5,
            'foiling' => 6,
            'cutting' => 7,
        ];

        $garantyCalculators = $labelTagType->calculators->whereIn('name', ['На листах с фольгой', 'На листах с белилами']);

        $garantyCalculators->each(fn (Calculator $calculator) => $calculator->fieldsSequence()->delete());

        foreach ($fieldSequenceSprings as $fieldName => $sequence) {
            $garantyCalculators->each(function (Calculator $calculator) use ($fieldName, $sequence) {
                $field = FormField::query()->where('name', $fieldName)->first();

                $calculator->fieldsSequence()->create([
                    'form_field_id' => $field->id,
                    'sequence' => $sequence
                ]);
            });
        }

        foreach ([
                [
                    'calculator' => $labelTagType->calculators->where('name', 'На листах с фольгой')->first(),
                    'codes' => ['#прилламYDFM', '#ламsoftYDFM']
                ],
                 [
                     'calculator' => $labelTagType->calculators->where('name', 'На листах с белилами')->first(),
                     'codes' => ['#прилламYDFM', '#ламsoftYDFM']
                 ]
             ] as $item) {
            foreach ($item['codes'] as $code) {
                $this->addPermWorkAdditional($item['calculator'], $code);
            }
        }
    }

    private function addPermWorkAdditional(Calculator $calculator, string $code): void
    {
        $workAdditional = WorkAdditional::query()->where('code', $code)->first();

        PivotWorkAdditional::query()->create([
            'work_additional_id' => $workAdditional->id,
            'calculator_id' => $calculator->id
        ]);
    }

    private function changeListsFoilings(Calculator $calculator, int $printId): void
    {
        $calculator->laminations()->each(
            fn (Lamination $lamination) => PivotCalculatorLamination::query()
                ->where('calculator_id', $calculator->id)->where('lamination_id', $lamination->id)
                ->update([
                    'print_id' => $printId
                ])
        );
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
