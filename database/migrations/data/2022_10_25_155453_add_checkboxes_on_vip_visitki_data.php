<?php

use App\Models\BlockSelectFieldConfig;
use App\Models\CalculatorCheckboxConfig;
use App\Models\FormField;
use App\Models\PivotCalculatorBlockSelectFields;
use App\Models\PivotCalculatorCheckboxConfig;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->setVipCheckboxes(3836, ["rounding_corners", "cliche"]);
        $this->setVipCheckboxes(3833, ["rounding_corners"]);
    }

    private function setVipCheckboxes(int $calculatorId, array $defaultCheckboxes): void
    {
        // "thermal_rise_face" - добавить к "Отделка лицо"
        // "thermal_rise_back" - добавить к "Отделка оборот"
        // "varnish_face" - добавить к "Отделка лицо"
        // "varnish_back" - добавить к "Отделка оборот"
        $pivotCalculatorCheckboxConfig = PivotCalculatorCheckboxConfig::query()
            ->where('calculator_id', $calculatorId)->first();

        CalculatorCheckboxConfig::query()
            ->where('id', $pivotCalculatorCheckboxConfig->calculator_checkbox_config_id)->update([
                'value' => $defaultCheckboxes
            ]);

        $blockSelectFields = BlockSelectFieldConfig::query()->where('calculator_id', $calculatorId)->get();

        $faceBlock = $blockSelectFields->first();
        $backBlock = $blockSelectFields->last();

        // добавление чекбоксов для "Отделка лицо"
        foreach (['thermal_rise_face', 'varnish_face'] as $fieldName) {
            $field = FormField::query()->where('name', $fieldName)->first();

            PivotCalculatorBlockSelectFields::query()->create([
                'form_field_id' => $field->id,
                'block_select_field_config_id' => $faceBlock->id
            ]);
        }

        // добавление чекбоксов для "Отделка оборот"
        foreach (['thermal_rise_back', 'varnish_back'] as $fieldName) {
            $field = FormField::query()->where('name', $fieldName)->first();

            PivotCalculatorBlockSelectFields::query()->create([
                'form_field_id' => $field->id,
                'block_select_field_config_id' => $backBlock->id
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
