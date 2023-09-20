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
        CalculatorType::query()->where('name', 'catalogs')->each(function (CalculatorType $calculatorType): void {
            $calculatorType->calculators()->each(function (Calculator $calculator) {
                $newPageOptions = $calculator->page()->create([
                    'print_time_description' => '<p>3-5 рабочих дней с момента оплаты и согласования макета</p>'
                ]);

                $calculator->update([
                    'calculator_page_id' => $newPageOptions->getKey()
                ]);
            });
        });

        CalculatorType::query()->whereNot('name', 'catalogs')->each(function (CalculatorType $calculatorType): void {
            $calculatorType->calculators()->each(function (Calculator $calculator) {
                $newPageOptions = $calculator->page()->create([
                    'print_time_description' => '<p>1-3 рабочих дня с момента оплаты и согласования макета</p>'
                ]);

                $calculator->update([
                    'calculator_page_id' => $newPageOptions->getKey()
                ]);
            });
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
