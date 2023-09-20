<?php

use App\Models\Calculator;
use App\Models\PrintForm;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculatorsPrintForm = [
            'Прямоугольные этикетки в рулоне' => 'Прямоугольная',
            'Овальные этикетки в рулоне' => 'Овальная',
            'Круглые этикетки в рулоне' => 'Круглая',
            'Фигурные этикетки в рулоне' => 'Сложная'
        ];

        // сделать отправку названия цвета - если кастомные
        foreach ($calculatorsPrintForm as $calculatorName => $calculatorPrintForm) {
            $calculator = Calculator::query()->where('name', $calculatorName)->first();
            $printForm = PrintForm::query()->where('name', $calculatorPrintForm)->first();

            $calculator->update([
                'print_form_id' => $printForm->id
            ]);
        }
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
