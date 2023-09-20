<?php

use App\Models\Calculator;
use App\Models\CalculatorType;
use App\Models\Cutting;
use App\Models\FormField;
use App\Models\PrintSize;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Cutting::query()->where('name', 'На общей подложке с надсечкой')->update([
            'name' => 'С надсечкой на общей подложке'
        ]);

        FormField::query()->where('name', 'volume')->first()->update([
            'parameters' => json_decode('{"info": false, "label": "Объемная наклейка", "checked": false, "formField": "volume", "labelModalLink": "volume-modal"}', true)
        ]);

        $nadpisiAndApplications = Calculator::query()->where('name', 'Надписи и аппликации')->first();

        $glassStickers = Calculator::query()->where('name', 'Стикеры на стекло')->first();

        // form => sequence
        $formFieldSequence = [
            'print_type' => 1,
            'width_height' => 2,
            'product_count_types' => 3,
            'material' => 4,
            'lam' => 5,
            'cutting' => 6
        ];

        foreach ($formFieldSequence as $fieldName => $sequence) {
            CalculatorType::query()->where('name', 'stickers')->first()->calculators->each(
                fn (Calculator $calculator) => $this->setFieldSequence(
                    $calculator,
                    $fieldName,
                    $sequence
                )
            );
        }

        foreach ([$glassStickers, $nadpisiAndApplications] as $calculator) {
            $this->stickersComplexCheckboxRefs($calculator);
        }

        FormField::query()->where('name', 'diameter')->update([
            'parameters' => json_decode('{"label": "Диаметр", "width": 64, "default": 50, "postText": "мм", "formField": "diameter", "numbersOnly": true, "labelModalLink": ""}', true)
        ]);

        $newPrintSizes = [
            [
                'name_old' => 'А6 (108х148мм)',
                'name' => 'А6 (105х148мм)',
                'short_name' => '105x148',
                'width' => 105
            ],
            [
                'name_old' => 'А5 (210х148мм)',
                'name' => 'А5 (148х210мм)',
                'short_name' => '148x210',
                'width' => 148,
                'height' => 210
            ]
        ];

        foreach ($newPrintSizes as $printSize) {
            $size = PrintSize::query()->where('name', $printSize['name_old'])->first();
            unset($printSize['name_old']);
            $size?->update($printSize);
        }

        $visitkyCalculators = CalculatorType::query()->where('name', 'businessCards')->first()
            ->calculators->whereNotIn('name', ['На прозрачном пластике', 'VIP']);

        $visitkyCalculators->each(fn (Calculator $calculator) => $calculator->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'product_count_types' => [
                    'hideTypes' => false,
                    'width' => 112
                ]
            ]
        ]));

        $calculatorsLabels = CalculatorType::query()->where('name', 'labels')->first()->calculators;

        $calculatorsLabels->each(fn (Calculator $calculator) => $calculator->fields()->create([
            'type' => 'fields_options',
            'value' => [
                'color' => [
                    'label' => 'Печать'
                ]
            ]
        ]));
    }

    private function stickersComplexCheckboxRefs(Calculator $calculator): void
    {
        $calculator->fields()->create([
            'type' => 'checkboxes_options',
            'value' => [
                'complex_form' => [
                    'conditions' => [
                        'checked' => [
                            [
                                'field' => 'mounting_film',
                                'value' => 1
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $calculator->fields()->create([
            'type' => 'checkboxes_options',
            'value' => [
                'complex_form' => [
                    'conditions' => [
                        'readonly' => [
                            [
                                'field' => 'cutting',
                                'value' => 5
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $calculator->fields()->create([
            'type' => 'checkboxes_options',
            'value' => [
                'complex_form' => [
                    'conditions' => [
                        'unchecked' => [
                            [
                                'field' => 'cutting',
                                'value' => 5
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * Устанавливает порядок полей у калькулятора
     * @param Calculator $calculator
     * @param string $fieldName
     * @param int $sequence
     * @return void
     */
    private function setFieldSequence(Calculator $calculator, string $fieldName, int $sequence): void
    {
        $calculator->fieldsSequence()->create([
            'form_field_id' => FormField::query()->where('name', $fieldName)->first()->id,
            'sequence' => $sequence
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
