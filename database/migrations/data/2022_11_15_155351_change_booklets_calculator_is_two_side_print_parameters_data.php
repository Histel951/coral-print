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
        $calculators = CalculatorType::query()->where('name', 'booklets')->first()
            ->calculators()->whereNot('id', 3867);

        $calculators->each(function (Calculator $calculator) {
            $calculator->update([
                'parameters' => [
                    'is_two_side_print' => true
                ]
            ]);
        });

        $leafletsCalculator = Calculator::query()->find(3867);

        $leafletsCalculator->printSizes()->where('name', 'А6 (105х210 мм)')->first()->update([
            'name' => 'А6 (105х148 мм)',
            'short_name' => '105х148',
            'width' => 105,
            'height' => 148
        ]);
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
