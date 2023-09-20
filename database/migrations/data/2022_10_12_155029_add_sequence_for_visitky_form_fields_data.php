<?php

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
        $businessCardType = CalculatorType::query()->where('name', 'businessCards')->first();

        // fieldName => sequence
        $fieldSequence = [
            'width_height' => 1,
            'diameter' => 2,
            'product_count_types' => 3,
            'form' => 4,
            'print_type_select' => 5,
            'material' => 6,
            'foiling_face' => 7
        ];

        foreach ($fieldSequence as $fieldName => $sequence) {
            $formField = FormField::query()->where('name', $fieldName)->first();

            FormFieldsSequence::query()->create([
                'calculator_type_id' => $businessCardType->id,
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
    public function down()
    {
        //
    }
};
