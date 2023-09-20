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
        $rulonsCalculatorType = CalculatorType::query()
            ->where('name', \App\Services\Calculator\CalculatorType::labelsTag->value)->first()->calculators;

        $rulonsCalculators = $rulonsCalculatorType->whereIn('name', [
            'Прямоугольные этикетки в рулоне',
            'Овальные этикетки в рулоне',
            'Круглые этикетки в рулоне',
            'Фигурные этикетки в рулоне',
            'Серебрянные и золотистые этикетки',
            'На прозрачной плёнке с белым',
            'Этикетки с персонализацией',
            'Термоэтикетка'
        ]);

        $rulonsCalculators->each(fn (Calculator $calculator) => $calculator->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'product_count_types' => [
                    'hideTypes' => true
                ]
            ]
        ]));
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
