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
        $standardBusinessCardCalculators = CalculatorType::query()->where('name', 'businessCards')->first()->calculators;

        $calculators = $standardBusinessCardCalculators->whereNotIn('name', [
            'На прозрачном пластике',
            'VIP'
        ]);

        $calculators->each(fn (Calculator $calculator) => $calculator->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'product_count_types' => [
                    'predefinedValues' => false
                ]
            ]
        ]));
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
