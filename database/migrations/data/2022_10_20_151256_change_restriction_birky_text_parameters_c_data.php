<?php

use App\Models\Calculator;
use App\Models\CalculatorRestriction;
use App\Models\CalculatorRestrictionMessage;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $messagePrint = "Макс. размер #print_max#x#print_min# мм<br>Мин. размер #min_size#x#min_size# мм";

        $calculatorsBirky = Calculator::query()->whereIn('name', [
            'Круглые воблеры',
            'Воблеры сложной формы',
            'Круглые бирки',
            'Бирки сложной формы',
            'Простые воблеры',
            'Хенгеры',
            'Простые бирки'
        ]);

        $calculatorsBirky->each(function (Calculator $calculator) use ($messagePrint): void {
            $calculator->restrictions()->each(function (CalculatorRestriction $restriction) use ($messagePrint) {
                $restriction->messages()->each(fn (CalculatorRestrictionMessage $message) => $message->update([
                    'text' => $messagePrint
                ]));
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
