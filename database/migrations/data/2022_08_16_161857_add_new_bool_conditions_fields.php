<?php

use App\Models\CalculatorFieldsConfig;
use App\Models\PivotWorkAdditional;
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
        PivotWorkAdditional::query()->create([
            'is_quantity_types' => 1,
            'work_additional_id' => 148
        ]);

        $configs = [
            [
                'id' => 19,
                'value' => json_decode('{"white_print": {"conditions": {"visible": [{"field": "print_type", "value": 14}]}}}'),
                'type' => 'checkboxes_options'
            ],
            [
                'id' => 21,
                'value' => json_decode('{"white_print": {"conditions": {"visible": [{"field": "print_type", "value": 14}]}}, "complex_form": {"conditions": {"checked": [{"field": "mounting_film", "value": 1}], "readonly": [{"field": "mounting_film", "value": 1}]}}}'),
                'type' => 'checkboxes_options'
            ]
        ];

        foreach ($configs as $config) {
            CalculatorFieldsConfig::find($config['id'])->delete();

            CalculatorFieldsConfig::query()->create($config);
        }

        // лишняя доп работа
//        PivotWorkAdditional::query()->find(13)->delete();

        $workAdditionalsPrintForm = [
            [
                'forms' => [55, 54, 56],
                'calculator' => 3821,
                'work_additional_id' => 44
            ],
            [
                'forms' => [57],
                'calculator' => 3821,
                'work_additional_id' => 45
            ],
        ];

        foreach ($workAdditionalsPrintForm as $item) {
            foreach ($item['forms'] as $form) {
                PivotWorkAdditional::query()->create([
                    'work_additional_id' => $item['work_additional_id'],
                    'calculator_id' => $item['calculator'],
                    'print_form_id' => $form,
                    'is_volume' => true
                ]);
            }
        }

        PrintForm::query()->find(54)->update([
            'is_diameter' => true
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
