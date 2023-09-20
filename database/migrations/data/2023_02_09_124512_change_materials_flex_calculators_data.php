<?php

use App\Models\Calculator;
use App\Models\MaterialType;
use App\Services\Calculator\CalculatorType;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $stickersCalculators = \App\Models\CalculatorType::query()
            ->where('name', CalculatorType::Stickers->value)->first()->calculators;
        $eticketsCalculators = \App\Models\CalculatorType::query()
            ->where('name', CalculatorType::labelsTag->value)->first()->calculators;

        $materialsCalculators = [
            'Круглые наклейки с логотипом' => 'Круглые наклейки с логотипом',
            'Прямоугольные стикеры' => 'Прямоугольные этикетки',
            'Фигурные стикеры' => 'Фигурные этикетки',
            'Овальные стикеры' => 'Овальные этикетки',
            'Стикеры с печатью белым' => 'На листах с белилами',
            'Наклейки с фольгой' => 'На листах с фольгой'
        ];

        foreach ($materialsCalculators as $fromCalculator => $toCalculator) {
            $this->copyMaterials(
                $stickersCalculators->where('name', $fromCalculator)->first(),
                $eticketsCalculators->where('name', $toCalculator)->first(),
            );
        }

        $allFlexMaterialsCalculators = [
           'Прямоугольные этикетки в рулоне',
            'Овальные этикетки в рулоне',
            'Круглые этикетки в рулоне',
            'Фигурные этикетки в рулоне'
        ];

        foreach ($allFlexMaterialsCalculators as $calculatorName) {
            Calculator::where('name', $calculatorName)->first()->materials()->sync(
                MaterialType::where('name', 'flex')->first()->materials->pluck('id')
            );
        }
    }

    public function copyMaterials(Calculator $fromCalculator, Calculator $toCalculator): void
    {
        $toCalculator->materials()->detach();
        $toCalculator->materials()->attach($fromCalculator->materials->pluck('id'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
    }
};
