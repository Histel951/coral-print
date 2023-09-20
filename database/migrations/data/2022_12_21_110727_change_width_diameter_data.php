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
        $calculators = CalculatorType::query()->where('name', 'businessCards')->first()->calculators;

        $calculators->each(fn (Calculator $calculator) => $calculator->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'product_count_types' => [
                    'isMultiple' => true
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
