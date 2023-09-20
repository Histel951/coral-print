<?php

use App\Models\BlockSelectFieldConfig;
use App\Models\Bolt;
use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\FormField;
use App\Models\PivotCalculatorBlockSelectFields;
use App\Models\PivotCalculatorBolt;
use App\Models\PivotCalculatorColor;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\PivotCalculatorFoiling;
use App\Models\PivotCalculatorLamination;
use App\Models\PivotCalculatorMaterial;
use App\Models\PivotCalculatorSpecieType;
use App\Models\PivotWorkAdditional;
use App\Models\WorkAdditional;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $boltCalculator = Calculator::query()->create([
            'name' => 'Брошюры на болтах',
            'description' => 'Брошюры на болтах',
            'calculator_type_id' => 3854,
            'min_price' => 30,
            'active' => true,
        ]);

        $this->setCalculatorsSub($boltCalculator);
        $this->setWorkAdditionals($boltCalculator);
        $this->setBolts($boltCalculator);
        $this->setSpecieTypes($boltCalculator);
        $this->setMaterials($boltCalculator);
        $this->setColors($boltCalculator);
        $this->setLaminations($boltCalculator);
        $this->setFoilings($boltCalculator);
        $this->setFieldOptions($boltCalculator);
        $this->setBlockSelectConfig($boltCalculator);
    }

    private function setBolts(Calculator $calculator): void
    {
        $boltWorkId = 150;
        if (!WorkAdditional::query()->find($boltWorkId)) {
            $boltWork = WorkAdditional::query()->create([
                'formula_id' => 2,
                'name' => 'Болты',
                'type_name' => 'Bolti',
                'color' => '#0ea586',
                'code' => '#болт',
                'weight' => 0,
                'volume' => 0,
                'times' => 1,
                'work_additional_type_id' => 16
            ]);

            $boltWork->prices()->sync([15]);
            $boltWorkId = $boltWork->getKey();
        }

        $bolts = [
            [
                'name' => 'Серебро',
                'counts' => [2, 3, 4],
            ],
            [
                'name' => 'Золото',
                'counts' => [2, 3, 4]
            ]
        ];

        foreach ($bolts as $bolt) {
            foreach ($bolt['counts'] as $count) {
                $newBolt = Bolt::query()->create([
                    'name' => $bolt['name'],
                    'count' => $count
                ]);

                PivotCalculatorBolt::query()->create([
                    'bolt_id' => $newBolt->getKey(),
                    'calculator_id' => $calculator->getKey(),
                    'calculator_sub_id' => 1
                ]);

                PivotWorkAdditional::query()->create([
                    'bolt_id' => $newBolt->getKey(),
                    'work_additional_id' => $boltWorkId,
                    'calculator_sub_id' => 1,
                    'repeat' => $count
                ]);

                PivotWorkAdditional::query()->create([
                    'bolt_id' => $newBolt->getKey(),
                    'work_additional_id' => 61,
                    'calculator_sub_id' => 1,
                    'repeat' => $count
                ]);

                PivotWorkAdditional::query()->create([
                    'bolt_id' => $newBolt->getKey(),
                    'calculator_sub_id' => 1,
                    'work_additional_id' => 60
                ]);
            }
        }
    }

    private function setWorkAdditionals(Calculator $calculator): void
    {
        $allWorkAdditionals = PivotWorkAdditional::query()
            ->where('calculator_id', 3866)
            ->whereNotIn('work_additional_id', [16, 17, 62, 64]);

        $allWorkAdditionals->each(
            fn (PivotWorkAdditional $pivotWorkAdditional) => PivotWorkAdditional::query()->create([
                ...$pivotWorkAdditional->toArray(),
                'calculator_id' => $calculator->getKey()
            ])
        );
    }

    private function setSpecieTypes(Calculator $calculator): void
    {
        $specieTypes = PivotCalculatorSpecieType::query()->where('calculator_id', 3866);

        $specieTypes->each(
            fn (PivotCalculatorSpecieType $pivotCalculatorSpecieType) => PivotCalculatorSpecieType::query()->create([
                'calculator_id' => $calculator->getKey(),
                'specie_type_id' => $pivotCalculatorSpecieType->specie_type_id,
                'print_id' => $pivotCalculatorSpecieType->print_id,
                'is_duplex' => $pivotCalculatorSpecieType->is_duplex,
                'calculator_sub_id' => $pivotCalculatorSpecieType->calculator_sub_id,
                'is_white_print' => $pivotCalculatorSpecieType->is_white_print
            ])
        );
    }

    private function setCalculatorsSub(Calculator $calculator): void
    {
        $calculator->calculatorSubs()->sync([1, 2]);
    }

    private function setFieldOptions(Calculator $calculator): void
    {
        $allIdsFieldsConfigs = PivotCalculatorFieldsConfig::query()
            ->where('calculator_id', 3866)
            ->pluck('calculator_fields_config_id');

        $allIdsFieldsConfigs = $allIdsFieldsConfigs->filter(fn ($id) => $id !== 11 and $id !== 15);

        $newBoltField = FormField::query()->create([
            'type' => 'select',
            'name' => 'bolt_cover_select',
            'parameters' => [
                'label' => 'Болты',
                'text_decoration' => "dashed",
                'formField' => 'bolt_cover_select',
                'sequence' => 5
            ]
        ]);

        $allFields = ["width_height", "page_count", "product_count", "material_wrapper", $newBoltField->name];

        $newFieldsListId = CalculatorFieldsConfig::query()->create([
            'type' => 'fields',
            'value' => $allFields
        ])->getKey();

        $allIdsFieldsConfigs->push($newFieldsListId);

        $allIdsFieldsConfigs->map(
            fn (int $fieldConfigId) => PivotCalculatorFieldsConfig::query()->create([
                'calculator_id' => $calculator->getKey(),
                'calculator_fields_config_id' => $fieldConfigId
            ])
        );
    }

    private function setBlockSelectConfig(Calculator $calculator): void
    {
        $coverCalculatorBlockConfig = BlockSelectFieldConfig::query()
            ->where('calculator_id', 3866)
            ->where('calculator_sub_id', 1)->first();

        $blockCalculatorBlockConfig = BlockSelectFieldConfig::query()
            ->where('calculator_id', 3866)
            ->where('calculator_sub_id', 2)->first();

        $newCoverCalculatorBoltConfig = BlockSelectFieldConfig::query()->create([
            'calculator_id' => $calculator->getKey(),
            'block_select_field_config_type_id' => $coverCalculatorBlockConfig->block_select_field_config_type_id,
            'active' => true,
            'calculator_sub_id' => $coverCalculatorBlockConfig->calculator_sub_id
        ]);

        $newBlockCalculatorBoltConfig = BlockSelectFieldConfig::query()->create([
            'calculator_id' => $calculator->getKey(),
            'block_select_field_config_type_id' => $blockCalculatorBlockConfig->block_select_field_config_type_id,
            'active' => true,
            'calculator_sub_id' => $blockCalculatorBlockConfig->calculator_sub_id
        ]);


        $coverFormFields = PivotCalculatorBlockSelectFields::query()
            ->where('block_select_field_config_id', $coverCalculatorBlockConfig->id)->pluck('form_field_id');

        $blockFormFields = PivotCalculatorBlockSelectFields::query()
            ->where('block_select_field_config_id', $blockCalculatorBlockConfig->id)->pluck('form_field_id');

        $coverFormFields->map(
            fn (int $fieldId) => PivotCalculatorBlockSelectFields::query()->create([
                'form_field_id' => $fieldId,
                'block_select_field_config_id' => $newCoverCalculatorBoltConfig->getKey()
            ])
        );

        $blockFormFields->map(
            fn (int $fieldId) => PivotCalculatorBlockSelectFields::query()->create([
                'form_field_id' => $fieldId,
                'block_select_field_config_id' => $newBlockCalculatorBoltConfig->getKey()
            ])
        );
    }

    private function setFoilings(Calculator $calculator): void
    {
        $allFoilings = PivotCalculatorFoiling::query()
            ->where('calculator_id', 3866);

        $allFoilings->each(
            fn (PivotCalculatorFoiling $pivotCalculatorFoiling) => PivotCalculatorFoiling::query()->create([
                'foiling_id' => $pivotCalculatorFoiling->foiling_id,
                'calculator_id' => $calculator->getKey()
            ])
        );
    }

    private function setLaminations(Calculator $calculator): void
    {
        $allLaminations = PivotCalculatorLamination::query()
            ->where('calculator_id', 3866);

        $allLaminations->each(
            fn (PivotCalculatorLamination $pivotCalculatorLamination): Model => PivotCalculatorLamination::query()->create([
                'calculator_id' => $calculator->getKey(),
                'lamination_id' => $pivotCalculatorLamination->lamination_id,
                'calculator_sub_id' => $pivotCalculatorLamination->calculator_sub_id
            ])
        );
    }

    private function setColors(Calculator $calculator): void
    {
        $allColors = PivotCalculatorColor::query()
            ->where('calculator_id', 3866);

        $allColors->each(
            fn (PivotCalculatorColor $pivotCalculatorColor): Model => PivotCalculatorColor::query()->create([
                'calculator_sub_id' => $pivotCalculatorColor->calculator_sub_id,
                'calculator_id' => $calculator->getKey(),
                'color_id' => $pivotCalculatorColor->color_id
            ])
        );
    }

    private function setMaterials(Calculator $calculator): void
    {
        $allMaterials = PivotCalculatorMaterial::query()
            ->where('calculator_id', 3855);

        $allMaterials->get()->map(
            fn (PivotCalculatorMaterial $pivotCalculatorMaterial): Model => PivotCalculatorMaterial::query()->create([
                'calculator_id' => $calculator->getKey(),
                'calculator_sub_id' => $pivotCalculatorMaterial->calculator_sub_id,
                'material_id' => $pivotCalculatorMaterial->material_id
            ])
        );
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
