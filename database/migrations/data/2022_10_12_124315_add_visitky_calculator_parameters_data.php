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
        $allVisitkiCalculators = CalculatorType::query()
            ->where('name', 'businessCards')
            ->first()->calculators;

        $allVisitkiCalculators->each(function (Calculator $calculator): void {
            Calculator::query()->find($calculator->id)->update([
                'parameters' => [
                    'big_departure_print_forms' => [54, 56, 57]
                ]
            ]);
        });
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
