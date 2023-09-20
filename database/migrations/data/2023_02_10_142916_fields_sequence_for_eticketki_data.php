<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Models\FormField;
use App\Models\FormFieldsSequence;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $rulonsCalculatorType = CalculatorType::query()
            ->where('name', \App\Services\Calculator\CalculatorType::labelsTag->value)->first()->calculators;

        $rulonsCalculators = $rulonsCalculatorType->whereIn('name', [
            'Прямоугольные этикетки в рулоне',
            'Овальные этикетки в рулоне',
            'Круглые этикетки в рулоне',
            'Фигурные этикетки в рулоне',
            'Серебрянные и золотистые этикетки',
            'На прозрачной плёнке с белым',
            'Этикетки с персонализацией',
            'Термоэтикетка'
        ]);

        $stickersEticketkiCalculators = $rulonsCalculatorType->whereNotIn('name', [
            'Прямоугольные этикетки в рулоне',
            'Овальные этикетки в рулоне',
            'Круглые этикетки в рулоне',
            'Фигурные этикетки в рулоне',
            'Серебрянные и золотистые этикетки',
            'На прозрачной плёнке с белым',
            'Этикетки с персонализацией',
            'Термоэтикетка'
        ]);

        $rulonsCalculators->each(fn (Calculator $calculator) => $this->rulonsFields($calculator));
        $stickersEticketkiCalculators->each(fn (Calculator $calculator) => $this->stickersFields($calculator));
    }

    private function stickersFields(Calculator $calculator): void
    {
        $fieldsSequence = CalculatorType::query()
            ->where('name', \App\Services\Calculator\CalculatorType::Stickers->value)->first()->calculators()
            ->first()->fieldsSequence;

        $fieldsSequence->each(fn (FormFieldsSequence $sequence) => $calculator->fieldsSequence()->create([
            'form_field_id' => $sequence->form_field_id,
            'sequence' => $sequence->sequence
        ]));
    }

    private function rulonsFields(Calculator $calculator): void
    {
        $fieldsSequence = [
            'form' => 1,
            'width_height_flex' =>  2,
            'product_count_types' => 3,
            'material_select' => 4,
            'color_paints' => 5,
            'ribbon' => 6,
            'location' => 7,
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
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        //
    }
};
