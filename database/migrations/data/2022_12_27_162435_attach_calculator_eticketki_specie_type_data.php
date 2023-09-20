<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Models\PivotCalculatorSpecieType;
use Illuminate\Database\Migrations\Migration;
use App\Services\Calculator\CalculatorType as CalculatorTypeE;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $stickersCalculators = CalculatorType::query()->where('name', CalculatorTypeE::Stickers->value)->first()->calculators;
        $calculators = CalculatorType::query()->where('name', CalculatorTypeE::labelsTag->value)->first()->calculators;

        $rectCalculator = $calculators->where('name', 'Прямоугольные этикетки')->first();
        $roundCalculator = $calculators->where('name', 'Круглые наклейки с логотипом')->first();
        $ovalCalculator = $calculators->where('name', 'Овальные этикетки')->first();
        $complexCalculator = $calculators->where('name', 'Фигурные этикетки')->first();
        $eticWhiteLists = $calculators->where('name', 'На листах с белилами')->first();
        $eticListWithFoiling = $calculators->where('name', 'На листах с фольгой')->first();

        $specieTypes = [
            [
                'calculator' => $rectCalculator,
                'specie_types' => [23 => 14, 35 => 15]
            ],
            [
                'calculator' => $roundCalculator,
                'specie_types' => [23 => 14, 35 => 15]
            ],
            [
                'calculator' => $ovalCalculator,
                'specie_types' => [23 => 14, 35 => 15]
            ],
            [
                'calculator' => $complexCalculator,
                'specie_types' => [23 => 14, 35 => 15]
            ],
            [
                'calculator' => $eticWhiteLists,
                'specie_types' => [21 => 17]
            ],
            [
                'calculator' => $eticListWithFoiling,
                'specie_types' => [35 => 15]
            ]
        ];

        foreach ($specieTypes as $item) {
            $this->setCalculatorSpecieType($item['calculator'], $item['specie_types']);
        }

        $eticWhiteLists->prints()->detach();
        $eticWhiteLists->prints()->attach(17);
        $eticListWithFoiling->prints()->detach();
        $eticListWithFoiling->prints()->attach(15);

        foreach ([$eticWhiteLists, $eticListWithFoiling] as $calculator) {
            $this->setCheckboxes($calculator);
        }

        $previews = [
            [
                'calculator' => $rectCalculator,
                'cutting_id' => 1,
                'old_calculator' => $stickersCalculators->where('name', 'Прямоугольные стикеры')->first()
            ],
            [
                'calculator' => $roundCalculator,
                'cutting_id' => 1,
                'old_calculator' => $stickersCalculators->where('name', 'Круглые наклейки с логотипом')->first()
            ],
            [
                'calculator' => $ovalCalculator,
                'cutting_id' => 1,
                'old_calculator' => $stickersCalculators->where('name', 'Овальные стикеры')->first()
            ],
            [
                'calculator' => $complexCalculator,
                'cutting_id' => 1,
                'old_calculator' => $stickersCalculators->where('name', 'Фигурные стикеры')->first()
            ]
        ];

        foreach ($previews as $preview) {
            $this->setDefaultPreviews($preview['calculator'], $preview['old_calculator'], $preview['cutting_id']);
        }
    }

    private function setDefaultPreviews(Calculator $calculator, Calculator $oldCalculator, int $cutting): void
    {
        $oldPreview = $oldCalculator->previews()->where('cutting_id', $cutting)->first();
        $calculator->previews()->create([
            'image' => $oldPreview->image,
            'calculator_type_id' => $calculator->calculatorType->id,
            'cutting_id' => $cutting,
            'form_id' => null,
            'sequence' => 1,
            'svg_id' => $oldPreview->svg_id
        ]);
    }

    /**
     * @param Calculator $calculator
     * @return void
     */
    private function setCheckboxes(Calculator $calculator): void
    {
        $calculator->checkboxes()->detach();

        $calculator->checkboxes()->create([
            'value' => ['reverse_sticker']
        ]);
    }

    /**
     * @param Calculator $calculator
     * @param array $specieTypeIds
     * @return void
     */
    private function setCalculatorSpecieType(Calculator $calculator, array $specieTypeIds): void
    {
        foreach ($specieTypeIds as $specieTypeId => $printId) {
            PivotCalculatorSpecieType::query()->create([
                'calculator_id' => $calculator->id,
                'print_id' => $printId,
                'specie_type_id' => $specieTypeId
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
