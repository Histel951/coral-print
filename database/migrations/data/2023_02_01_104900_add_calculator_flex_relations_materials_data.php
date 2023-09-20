<?php

use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculators = \App\Models\CalculatorType::query()->where('name', \App\Services\Calculator\CalculatorType::labelsTag->value)
            ->first()->calculators;

        $materialsRibbon = \App\Models\MaterialCategory::query()->where('name', 'Рибон')->first()->materials->pluck('id');

        $calculators->each(function (\App\Models\Calculator $calculator) use ($materialsRibbon) {
            $materialsRibbon->each(fn (int $materialId) => $calculator->materials()->detach($materialId));
        });

        $rectCalculator = \App\Models\Calculator::query()->where('name', 'Прямоугольные этикетки в рулоне')->first();

        $rectCalculator->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'product_count_types' => [
                    'isHideTypes' => true
                ]
            ]
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
