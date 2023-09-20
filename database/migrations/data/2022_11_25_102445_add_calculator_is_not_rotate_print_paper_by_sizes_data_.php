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
        $calculators = CalculatorType::query()->where('name', 'booklets')
            ->whereNot('id', 3867)->first()->calculators;

        $calculators->each(fn (Calculator $calculator) => $calculator->update([
            'parameters' => [
                'is_two_side_print' => true,
                'is_no_rotate_print_paper' => true
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
