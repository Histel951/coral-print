<?php

use App\Models\Calculator;
use App\Models\CalculatorModelTextDataMessage;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculator = Calculator::query()->where('name', 'Серебрянные и золотистые этикетки')->first();

        $calculator->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'width_height_flex' => [
                    'url' => route('calculator.knifes'),
                    'deps' => ['form']
                ]
            ]
        ]);

        $calculator->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'color_paints' => [
                    'is_disabled_custom' => true,
                    'is_disabled' => true
                ]
            ]
        ]);

        $rectCalc = Calculator::query()->where('name', 'Прямоугольные этикетки в рулоне')->first();
        $ovalCalc = Calculator::query()->where('name', 'Овальные этикетки в рулоне')->first();
        $roundCalc = Calculator::query()->where('name', 'Круглые этикетки в рулоне')->first();
        $complexCalc = Calculator::query()->where('name', 'Фигурные этикетки в рулоне')->first();

        $this->changePrintFormModelTextDataMessage([$rectCalc, $ovalCalc, $roundCalc, $complexCalc]);
    }

    /**
     * @param Calculator[] $calculators
     * @return void
     */
    private function changePrintFormModelTextDataMessage(array $calculators): void
    {
        foreach ($calculators as $calculator) {
            CalculatorModelTextDataMessage::query()->where('calculator_id', $calculator->id)->update([
               'print_form_id' => $calculator->printForm?->id
            ]);
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
