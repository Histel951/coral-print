<?php

use App\Models\CalculatorFieldsConfig;
use App\Models\FormField;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Arr;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // [field] name => 'new value'
        $data = [
            'material_cover' => 'Материал',
            'lam_cover' => 'Ламинация',
            'color_cover' => 'Печать',
            'foiling_cover' => 'Фольга',
            'material_block' => 'Материал',
            'lam_block' => 'Ламинация',
            'color_block' => 'Печать',
            'foiling_block' => 'Фольга',
            'material_substrate' => 'Материал',
            'lam_substrate' => 'Ламинация',
            'color_substrate' => 'Печать',
            'foiling_substrate' => 'Фольга',
            'print_type_cover' => 'Печать',
            'print_type_block' => 'Печать',
            'print_type_substrate' => 'Печать',
        ];

        foreach ($data as $fieldName => $value) {
            FormField::query()->where('name', $fieldName)->update([
                'parameters->label' => $value
            ]);
        }

        if (!FormField::query()->where('name', 'page_count_sheets')->first()) {
            $pageCountSheets = FormField::query()->create([
                'name' => 'page_count_sheets',
                'type' => 'input',
                'parameters' => [
                    "type" => "input",
                    "default" => 8,
                    "numbersOnly" => true,
                    "postText" => "не включая обложку и подложку",
                    "formField" => "page_count",
                    "label" => "Листов"
                ],
                'sequence' => 2
            ]);
        }


        $dashedTextDecoration = [22, 24, 28, 29, 30, 36, 35, isset($pageCountSheets) ? $pageCountSheets?->getKey() : null];

        foreach ($dashedTextDecoration as $formFieldId) {
            if ($formFieldId) {
                $formField = FormField::query()->find($formFieldId);

                $formField->update([
                    'parameters' => Arr::collapse([$formField->parameters, ['text_decoration' => 'dashed']])
                ]);
            }
        }

        FormField::query()->find(22)->update([
            'sequence' => 2
        ]);

        FormField::query()->find(3)->update([
            'sequence' => 4
        ]);

        FormField::query()->find(48)->update([
            'sequence' => 3
        ]);

        if (isset($pageCountSheets)) {
            $config = CalculatorFieldsConfig::query()->find(11);
            $value = $config->value;
            $value[1] = 'page_count_sheets';
            $config->update([
                'value' => $value
            ]);
        }

        if (!FormField::query()->where('name', 'edition_count')->first()) {
            // id - 3, {"label": "Количество", "default": 300, "postText": "шт", "formField": "product_count", "numbersOnly": true}
            FormField::query()->create([
                'name' => 'edition_count',
                'type' => 'input',
                'sequence' => 4,
                'parameters' => [
                    'label' => 'Тираж',
                    'default' => 300,
                    'postText' => 'шт',
                    'formField' => 'product_count',
                    'numbersOnly' => true
                ]
            ]);

            // 3855

            $config = CalculatorFieldsConfig::query()->find(12);
            $value = $config->value;
            $value[2] = 'edition_count';
            $config->update([
                'value' => $value
            ]);
        }

//        if (!FormField::query()->where('name', 'width_height_no_scroll')->first()) {
//            // id - 2 {"info": [], "label": "Размер", "formField": "width_height", "formWidthField": "width", "labelInnerText": "(↔✗↕)", "labelModalLink": "", "formHeightField": "height"}
//            $oldField = FormField::query()->find(2);
//
//            FormField::query()->create([
//                'type' => "width-height",
//                'parameters' => Arr::collapse([$oldField->parameters, ['isScrolling' => false]]),
//                'sequence' => 1,
//                'name' => 'width_height_no_scroll'
//            ]);
//
//            $allOptionsWithWidthHeight = [11, 12, 13];
//            foreach ($allOptionsWithWidthHeight as $optionId)
//            {
//                $formField = CalculatorFieldsConfig::query()->find($optionId);
//
//                $value = $formField->value;
//                foreach ($value as $key => $field)
//                {
//                    if ($field === 'width_height') {
//                        unset($value[$key]);
//                        $value[$key] = 'width_height_no_scroll';
//
//                        $formField->update([
//                            'value' => array_values($value)
//                        ]);
//                    }
//                }
//            }
//        }
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
