<?php

use App\Models\Calculator;
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
        $springsCalculators = CalculatorType::query()->where('name', 'catalogs')->first()->calculators
            ->whereIn('name', ['Презентации', 'Блокноты']);

        $fieldSequenceSprings = [
            'sprint_position' => 1,
            'width_height' => 2,
            'tooltip_print' => 3,
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
        // labelInnerText
        $boltCalculator = CalculatorType::query()->where('name', 'catalogs')->first()->calculators
            ->where('name', 'Брошюры на болтах')->first();

        $boltCalculator->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height' => [
                    'labelInnerText' => '(↔✗↕)'
                ]
            ]
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
