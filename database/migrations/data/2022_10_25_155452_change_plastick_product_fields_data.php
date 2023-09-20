<?php

use App\Models\BlockSelectFieldConfig;
use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\FormField;
use App\Models\PivotCalculatorBlockSelectFields;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\PivotCalculatorSub;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use App\Models\BlockSelectFieldConfigTypes;
use App\Models\CalculatorSub;

return new class () extends Migration {
    private BlockSelectFieldConfig|Model $finishingFaceBlockSelect;

    private BlockSelectFieldConfig|Model $finishingBackBlockSelect;

    private array $allFields = ["width_height", "product_count", 'material', "material_wrapper"];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculators = Calculator::query()->whereIn('id', [3833]);

        $this->deleteOldFields($calculators);

        $this->finishingFaceBlockSelect = BlockSelectFieldConfigTypes::query()
            ->where('name', 'Отделка лицо')->first();

        $this->finishingBackBlockSelect = BlockSelectFieldConfigTypes::query()
            ->where('name', 'Отделка оборот')->first();

        $calculatorSubFace = CalculatorSub::query()->where('name', 'visitki_vip_face')->first();

        $calculatorSubBack = CalculatorSub::query()->where('name', 'visitki_vip_back')->first();

        $this->setCalculatorSubs($calculators, $calculatorSubFace);
        $this->setCalculatorSubs($calculators, $calculatorSubBack);

        $this->setBlockSelectConfigs($calculators, $calculatorSubFace, $this->finishingFaceBlockSelect);
        $this->setBlockSelectConfigs($calculators, $calculatorSubBack, $this->finishingBackBlockSelect);

        $fieldsFaceNames = [
            'color_count_face'
        ];

        $fieldsBackNames = [
            'color_count_back'
        ];

        $this->setBlockSelectFields($fieldsFaceNames, $calculators, $this->finishingFaceBlockSelect);
        $this->setBlockSelectFields($fieldsBackNames, $calculators, $this->finishingBackBlockSelect);
    }

    private function setBlockSelectFields(array $names, Builder $calculators, BlockSelectFieldConfigTypes $selectFieldConfigTypes)
    {
        $calculators->each(function (Calculator $calculator) use ($names, $selectFieldConfigTypes): void {
            foreach ($names as $fieldName) {
                $field = FormField::query()->where('name', $fieldName)->first();

                $blockSelectFieldConfig = $calculator->blockSelectField()
                    ->where('block_select_field_config_type_id', $selectFieldConfigTypes->getKey())
                    ->where('active', true)->first();

                PivotCalculatorBlockSelectFields::query()->create([
                    'form_field_id' => $field->id,
                    'block_select_field_config_id' => $blockSelectFieldConfig->id
                ]);
            }
        });
    }

    private function deleteOldFields(Builder $calculators): void
    {
        $calculators->each(function (Calculator $calculator) {
            $calculator->fieldsConfig()->each(function (CalculatorFieldsConfig $fieldsConfig): void {
                if ($fieldsConfig->type === 'fields') {
                    $fieldsConfig->delete();
                }
            });
        });

        $newConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'fields',
            'value' => $this->allFields
        ]);

        $calculators->each(fn (Calculator $calculator) => PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_fields_config_id' => $newConfig->getKey()
        ]));
    }

    private function setCalculatorSubs(Builder $calculators, CalculatorSub $calculatorSub): void
    {
        $calculators->each(fn (Calculator $calculator) => PivotCalculatorSub::query()->create([
            'calculator_sub_id' => $calculatorSub->getKey(),
            'calculator_id' => $calculator->id
        ]));
    }

    private function setBlockSelectConfigs(
        Builder $calculators,
        CalculatorSub $calculatorSub,
        BlockSelectFieldConfigTypes $blockSelectFieldConfigTypes
    ): void {
        $calculators->each(fn (Calculator $calculator) => BlockSelectFieldConfig::query()->create([
            'calculator_id' => $calculator->id,
            'calculator_sub_id' => $calculatorSub->getKey(),
            'active' => true,
            'block_select_field_config_type_id' => $blockSelectFieldConfigTypes->getKey()
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
