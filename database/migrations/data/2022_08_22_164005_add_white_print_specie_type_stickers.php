<?php

use App\Models\PivotCalculatorSpecieType;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $whitePrint = [
            'calculators' => [3820, 3823, 3818],
            'specie_type_id' => 21,
            'prints' => [15, 14, 17]
        ];

        foreach ($whitePrint['calculators'] as $calculatorId) {
            foreach ($whitePrint['prints'] as $printId) {
                PivotCalculatorSpecieType::query()->create([
                    'calculator_id' => $calculatorId,
                    'specie_type_id' => $whitePrint['specie_type_id'],
                    'print_id' => $printId,
                    'is_white_print' => 1
                ]);
            }
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
