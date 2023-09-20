<?php

use App\Models\Calculator;
use App\Models\CalculatorCheckboxConfig;
use App\Models\CalculatorConfig;
use App\Models\CalculatorType;
use App\Models\Cutting;
use App\Models\Lamination;
use App\Models\Material;
use App\Models\PivotCalculatorCheckboxConfig;
use App\Models\PivotCalculatorLamination;
use App\Models\PivotCalculatorMaterial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Тип новых калькуляторов
     * @var CalculatorType|Model
     */
    private readonly CalculatorType|Model $calculatorType;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->calculatorType = CalculatorType::query()->create([
            'name' => 'labelsTag'
        ]);

        $rectLabels = Calculator::query()->create([
            'name' => 'Прямоугольные этикетки',
            'description' => 'Прямоугольные этикетки',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->calculatorType->getKey(),
            'svg_id' => 'label-tag-rect'
        ]);

        $roundLabels = Calculator::query()->create([
            'name' => 'Круглые наклейки с логотипом',
            'description' => 'Круглые наклейки с логотипом',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->calculatorType->getKey(),
            'svg_id' => 'label-tag-round'
        ]);

        $ovalLabels = Calculator::query()->create([
            'name' => 'Овальные этикетки',
            'description' => 'Овальные этикетки',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->calculatorType->getKey(),
            'svg_id' => 'labels-tag-oval'
        ]);

        $complexLabels = Calculator::query()->create([
            'name' => 'Фигурные этикетки',
            'description' => 'Фигурные этикетки',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->calculatorType->getKey(),
            'svg_id' => 'labels-tag-complex'
        ]);

        $opacityLabels = Calculator::query()->create([
            'name' => 'На листах с белилами',
            'description' => 'На листах с белилами',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->calculatorType->getKey(),
            'svg_id' => 'labels-tag-opacity'
        ]);

        $foilingLabels = Calculator::query()->create([
            'name' => 'На листах с фольгой',
            'description' => 'На листах с фольгой',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->calculatorType->getKey(),
            'svg_id' => 'labels-tag-foiling'
        ]);

        $this->copyCalculatorsStickers([
            ['old' => Calculator::query()->find(3815), 'new' => $roundLabels],
            ['old' => Calculator::query()->find(3816), 'new' => $rectLabels],
            ['old' => Calculator::query()->find(3827), 'new' => $ovalLabels],
            ['old' => Calculator::query()->find(3817), 'new' => $complexLabels],
            ['old' => Calculator::query()->find(3819), 'new' => $opacityLabels],
            ['old' => Calculator::query()->find(3821), 'new' => $foilingLabels]
        ]);
    }

    /**
     * @param Calculator[] $calculators [oldCalculator => newCalculator]
     * @return void
     */
    public function copyCalculatorsStickers(array $calculators): void
    {
        foreach ($calculators as $newOldCalculator) {
            $newOldCalculator['old']->materials()->each(
                fn (Material $material) => PivotCalculatorMaterial::query()->create([
                    'calculator_id' => $newOldCalculator['new']->getKey(),
                    'material_id' => $material->id,
                    'print_id' => PivotCalculatorMaterial::query()
                        ->where('calculator_id', $newOldCalculator['old']->id)
                        ->where('material_id', $material->id)->first()->print_id
                ])
            );

            $newOldCalculator['old']->laminations()->each(
                fn (Lamination $lamination) => PivotCalculatorLamination::query()->create([
                    'calculator_id' => $newOldCalculator['new']->getKey(),
                    'lamination_id' => $lamination->id,
                    'print_id' => PivotCalculatorLamination::query()
                        ->where('calculator_id', $newOldCalculator['old']->id)
                        ->where('lamination_id', $lamination->id)->first()->print_id
                ])
            );

            $allPrintsIds = $newOldCalculator['old']->prints()->get()->pluck('id');
            $allPrintSizesIds = $newOldCalculator['old']->printSizes()->get()->pluck('id');
            $allFoilingIds = $newOldCalculator['old']->foilings()->get()->pluck('id');
            $allFormIds = $newOldCalculator['old']->forms()->get()->pluck('id');
            $allFieldsIds = $newOldCalculator['old']->fields()->get()->pluck('id');
            $allCheckboxes = $newOldCalculator['old']->checkboxes()->first()?->value;
            $allConfigs = $newOldCalculator['old']->configs();

            $newOldCalculator['new']->cuttings()->sync(Cutting::query()->where('name', 'На общей подложке с надсечкой')->first()->id);
            $newOldCalculator['new']->prints()->sync($allPrintsIds);
            $newOldCalculator['new']->printSizes()->sync($allPrintSizesIds);
            $newOldCalculator['new']->foilings()->sync($allFoilingIds);
            $newOldCalculator['new']->forms()->sync($allFormIds);
            $newOldCalculator['new']->fields()->sync($allFieldsIds);

            if ($allCheckboxes && isset($allCheckboxes['volume'])) {
                unset($allCheckboxes['volume']);
            }

            if (isset($allCheckboxes) && count($allCheckboxes)) {
                $checkboxes = CalculatorCheckboxConfig::query()->create([
                    'value' => $allCheckboxes
                ]);

                PivotCalculatorCheckboxConfig::query()->create([
                    'calculator_checkbox_config_id' => $checkboxes->getKey(),
                    'calculator_id' => $newOldCalculator['new']->getKey()
                ]);
            }

            $allConfigs->each(
                fn (CalculatorConfig $calculatorConfig) => CalculatorConfig::query()->create([
                    'name' => $calculatorConfig->name,
                    'value' => $calculatorConfig->value,
                    'calculator_id' => $newOldCalculator['new']->getKey()
                ])
            );
        }
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
