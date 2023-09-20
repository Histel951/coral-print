<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // 'type' => 'fields_options',
        //            'value' => [
        //                'fold_count' => [
        //                    'isUseValue' => true
        //                ]
        //            ]

        $calculators = CalculatorType::query()->where('name', 'businessCards')->first()->calculators()->whereIn('name', ['VIP', 'С фольгированием']);

        $calculators->each(
            fn (Calculator $calculator) => $calculator->fields()->create([
            'type' => 'fields_options',
            'value' => [
                    'color_count_face' => [
                        'isUseValue' => true
                    ]
                ]
            ])
        );

        $calculators->each(
            fn (Calculator $calculator) => $calculator->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height' => [
                    'predefinedValues' => false
                ]
            ]
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
