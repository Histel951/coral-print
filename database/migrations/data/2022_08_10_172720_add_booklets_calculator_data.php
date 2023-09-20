<?php

use App\Models\Bend;
use App\Models\Calculator;
use App\Models\CalculatorFieldsConfig;
use App\Models\CalculatorType;
use App\Models\Color;
use App\Models\FormField;
use App\Models\PivotCalculatorBend;
use App\Models\PivotCalculatorColor;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\PivotCalculatorLamination;
use App\Models\PivotCalculatorMaterial;
use App\Models\PivotCalculatorPrintSize;
use App\Models\PivotCalculatorSpecieType;
use App\Models\PivotWorkAdditional;
use App\Models\PrintSize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Orchid\Attachment\File;

// todo: сделать цветность через radio input, потому что он нужен чисто чтобы отправлять duplex или не duplex

return new class () extends Migration {
    /**
     * @var CalculatorType|Model
     */
    private CalculatorType|Model $calculatorTypeBooklets;

    /**
     * Листовки
     * @var Calculator|Model
     */
    private Calculator|Model $calculatorFlyers;

    /**
     * Буклет "Книжка" 1 сгиб
     * @var Calculator|Model
     */
    private Calculator|Model $calculatorBook1;

    /**
     * Буклет "Евро" 2 сложения
     * @var Calculator|Model
     */
    private Calculator|Model $calculatorEuro2;

    /**
     * Буклет "Гармошка" 2 сложения
     * @var Calculator|Model
     */
    private Calculator|Model $calculatorHarmonic2;

    /**
     * Буклет "Гармошка" 3 сложения
     * @var Calculator|Model
     */
    private Calculator|Model $calculatorHarmonic3;

    /**
     * @var Calculator|Model
     */
    private Calculator|Model $calculatorSnail3;

    /**
     * @var Calculator|Model
     */
    private Calculator|Model $calculatorVip;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        $this->calculators();
        $this->printSizes();
        $this->materials();
        $this->laminations();
        $this->bends();
        $this->fields();
        $this->colors();
        $this->calculatorImages();
        $this->workAdditionals();
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
    }

    private function workAdditionals()
    {
        $works = [
            [
                'calculators' => [
                    $this->calculatorFlyers->getKey(),
                    $this->calculatorVip->getKey(),
//                    $this->calculatorHarmonic3->getKey(),
//                    $this->calculatorHarmonic2->getKey(),
//                    $this->calculatorEuro2->getKey(),
//                    $this->calculatorBook1->getKey(),
//                    $this->calculatorSnail3->getKey()
                ],
                'lamination_works' => [
                    // laminationId => [workId => times]
                    112 => [28 => 1, 32 => 1],
                    113 => [28 => 1, 32 => 1],
                    114 => [28 => 2, 32 => 1],
                    115 => [28 => 2, 32 => 1],
                    116 => [37 => 1, 32 => 1],
                    117 => [37 => 2, 32 => 1],
                ],
            ],
            [
                'calculators' => [
                    $this->calculatorFlyers->getKey()
                ],
                'works' => [54 => 1, 57 => 1]
            ],
            [
                'calculators' => [
                    $this->calculatorVip->getKey(),
                    $this->calculatorHarmonic3->getKey(),
                    $this->calculatorHarmonic2->getKey(),
                    $this->calculatorEuro2->getKey(),
                    $this->calculatorBook1->getKey(),
                    $this->calculatorSnail3->getKey()
                ],
                'works' => [21 => 1,  67 => 1, 54 => 1, 57 => 1]
            ],
            [
                'calculators' => [
                    $this->calculatorBook1->getKey()
                ],
                'works' => [18 => 1, 68 => 1]
            ],
            [
                'calculators' => [
                    $this->calculatorHarmonic2->getKey(),
                    $this->calculatorEuro2->getKey()
                ],
                'works' => [18 => 2, 68 => 2]
            ],
            [
                'calculators' => [
                    $this->calculatorHarmonic3->getKey(),
                    $this->calculatorSnail3->getKey()
                ],
                'works' => [18 => 3, 68 => 3]
            ],
            [
                'calculators' => [
                    $this->calculatorVip->getKey(),
                    $this->calculatorHarmonic3->getKey(),
                    $this->calculatorHarmonic2->getKey(),
                    $this->calculatorEuro2->getKey(),
                    $this->calculatorBook1->getKey(),
                    $this->calculatorSnail3->getKey()
                ],
                'works' => [21, 67, 54, 57]
            ],
            // todo: доделать доп работы для Вип калькулятора
            [
                'calculators' => [
                    $this->calculatorVip->getKey()
                ],
                'works' => [18, 68]
            ]
        ];

        foreach ($works as $item) {
            foreach ($item['calculators'] as $calculatorId) {
                if (isset($item['lamination_works'])) {
                    foreach ($item['lamination_works'] as $laminationId => $worksTimes) {
                        foreach ($worksTimes as $workId => $times) {
                            PivotWorkAdditional::query()->create([
                                'calculator_id' => $calculatorId,
                                'lamination_id' => $laminationId,
                                'repeat' => $times,
                                'work_additional_id' => $workId
                            ]);
                        }
                    }
                }

                if (isset($item['works'])) {
                    foreach ($item['works'] as $workId => $times) {
                        PivotWorkAdditional::query()->create([
                            'work_additional_id' => $workId,
                            'calculator_id' => $calculatorId,
                            'repeat' => $times
                        ]);
                    }
                }
            }
        }
    }

    private function calculatorImages(): void
    {
        $calculatorImage = [
            $this->calculatorFlyers->getKey() => [
                'path' => 'images/calculators/Icon-Booklets&Flyaers.svg',
                'name' => 'Icon-Booklets&Flyaers.svg',
            ],
            $this->calculatorBook1->getKey() => [
                'path' => 'images/calculators/Icon-Booklet-Book.svg',
                'name' => 'Icon-Booklet-Book.svg',
            ],
            $this->calculatorEuro2->getKey() => [
                'path' => 'images/calculators/Icon-Booklet-Euro.svg',
                'name' => 'Icon-Booklet-Euro.svg',
            ],
            $this->calculatorHarmonic2->getKey() => [
                'path' => 'images/calculators/Icon-Booklet-Accordion-2folds.svg',
                'name' => 'Icon-Booklet-Accordion-2folds.svg',
            ],
            $this->calculatorHarmonic3->getKey() => [
                'path' => 'images/calculators/Icon-Booklet-Accordion-3folds.svg',
                'name' => 'Icon-Booklet-Accordion-3folds.svg',
            ],
            $this->calculatorSnail3->getKey() => [
                'path' => 'images/calculators/Icon-Booklet-Snail-3folds.svg',
                'name' => 'Icon-Booklet-Snail-3folds.svg',
            ],
            $this->calculatorVip->getKey() => [
                'path' => 'images/calculators/Icon-Booklet-VIP.svg',
                'name' => 'Icon-Booklet-VIP.svg',
            ]
        ];

        foreach ($calculatorImage as $calculatorId => $item) {
            $file = new UploadedFile(public_path($item['path']), $item['name']);
            $attachment = (new File($file))->load();

            Calculator::find($calculatorId)->update([
                'image_id' => $attachment->getKey()
            ]);
        }
    }

    private function colors(): void
    {
        $colors = [
            [
                'name' => 'Цветная, с одной стороны',
                'print_id' => 125,
                'calculators' => [
                    $this->calculatorFlyers->getKey(),
                    $this->calculatorVip->getKey()
                ],
                'specie_type_id' => 30,
                'is_duplex' => false
            ],
            [
                'name' => 'Цветная, с двух сторон',
                'print_id' => 126,
                'calculators' => [
                    $this->calculatorFlyers->getKey(),
                    $this->calculatorVip->getKey()
                ],
                'specie_type_id' => 30,
                'is_duplex' => false
            ]
        ];

        foreach ($colors as $color) {
            foreach ($color['calculators'] as $calculatorId) {
                $newColor = Color::query()->create([
                    'name' => $color['name'],
                    'print_id' => $color['print_id']
                ]);

                PivotCalculatorColor::query()->create([
                    'color_id' => $newColor->getKey(),
                    'calculator_id' => $calculatorId
                ]);

                PivotCalculatorSpecieType::query()->create([
                    'calculator_id' => $calculatorId,
                    'specie_type_id' => $color['specie_type_id'],
                    'is_duplex' => $color['is_duplex'],
                    'print_id' => $color['print_id']
                ]);
            }
        }
    }

    private function fields(): void
    {
        $newFormFields = [
            'bend' => [
                "type" => "select",
                "formField" => "embossing_face2",
                "dataField" => "embossing_face2",
                "label" => "Сложение"
            ],
            "color_radio" => [
                'formField' => 'color_radio',
                "dataField" => "color_radio",
                'label' => 'Цветность',
                'type' => 'radio-check-btn'
            ],
            "print_select" => [
                "type" => "select",
                "formField" => "print_select",
                "dataField" => "print_select",
                "label" => "Печать",
            ]
        ];

        foreach ($newFormFields as $name => $field) {
            $parameters = $field;
            unset($parameters['type']);

            FormField::query()->create([
                'name' => $name,
                'type' => $field['type'],
                'parameters' => $parameters
            ]);
        }

        $fields = [
            [
                'calculators' => [
                    $this->calculatorFlyers->getKey()
                ],
                'type' => 'fields',
                'value' => ['width_height', 'product_count', 'print_select', 'lam', 'material']
            ],
            [
                'calculators' => [
                    $this->calculatorBook1->getKey(),
                    $this->calculatorEuro2->getKey(),
                    $this->calculatorHarmonic2->getKey(),
                    $this->calculatorHarmonic3->getKey(),
                    $this->calculatorSnail3->getKey()
                ],
                'type' => 'fields',
                'value' => ['width_height', 'product_count', 'lam', 'material']
            ],
            [
                'calculators' => [
                    $this->calculatorFlyers->getKey(),
                    $this->calculatorBook1->getKey(),
                    $this->calculatorEuro2->getKey(),
                    $this->calculatorHarmonic2->getKey(),
                    $this->calculatorHarmonic3->getKey(),
                    $this->calculatorSnail3->getKey()
                ],
                'type' => 'fields_options',
                'value' => [
                    'width_height' => [
                        'predefinedValues' => true,
                        'labelInnerText' => '',
                        'label' => 'Размер в развороте',
                    ],
                ]
            ],
            [
                'calculators' => [
                    $this->calculatorBook1->getKey(),
                    $this->calculatorEuro2->getKey(),
                    $this->calculatorHarmonic2->getKey(),
                    $this->calculatorHarmonic3->getKey(),
                    $this->calculatorSnail3->getKey()
                ],
                'type' => 'fields_options',
                'value' => [
                    'lam' => [
                        'disabled' => true
                    ],
                ]
            ]
        ];

        foreach ($fields as $item) {
            $newFieldConfig = CalculatorFieldsConfig::query()->create([
                'value' => $item['value'],
                'type' => $item['type']
            ]);

            foreach ($item['calculators'] as $calculatorId) {
                PivotCalculatorFieldsConfig::query()->create([
                    'calculator_id' => $calculatorId,
                    'calculator_fields_config_id' => $newFieldConfig->getKey()
                ]);
            }
        }
    }

    private function bends(): void
    {
        $bends = [
            [
                'bends' => ['1 сгиб' => 1, '2 сгиба' => 2, '3 сгиба' => 3, '4 сгиба' => 4, '5 сгибов' => 5],
                'calculators' => [$this->calculatorVip->getKey()]
            ]
        ];

        foreach ($bends as $item) {
            foreach ($item['calculators'] as $calculator) {
                foreach ($item['bends'] as $name => $value) {
                    $newBend = Bend::query()->create([
                        'name' => $name,
                        'value' => $value
                    ]);

                    PivotCalculatorBend::query()->create([
                        'calculator_id' => $calculator,
                        'bend_id' => $newBend->getKey()
                    ]);
                }
            }
        }
    }

    private function laminations(): void
    {
        $laminations = [
            [
                'calculators' => [
                    $this->calculatorVip->getKey(),
                    $this->calculatorFlyers->getKey(),
                ],
                'laminations' => [45, 112, 113, 114, 115, 116, 117]
            ],
            [
                'calculators' => [
                    $this->calculatorBook1->getKey(),
                    $this->calculatorEuro2->getKey(),
                    $this->calculatorHarmonic2->getKey(),
                    $this->calculatorHarmonic3->getKey(),
                    $this->calculatorSnail3->getKey()
                ],
                'laminations' => [45]
            ]
        ];

        foreach ($laminations as $item) {
            foreach ($item['calculators'] as $calculatorId) {
                foreach ($item['laminations'] as $laminationId) {
                    PivotCalculatorLamination::query()->create([
                        'calculator_id' => $calculatorId,
                        'lamination_id' => $laminationId
                    ]);
                }
            }
        }
    }

    private function materials(): void
    {
        $materials = [
            'calculators' => [
                $this->calculatorFlyers->getKey(),
                $this->calculatorBook1->getKey(),
                $this->calculatorEuro2->getKey(),
                $this->calculatorHarmonic2->getKey(),
                $this->calculatorHarmonic3->getKey(),
                $this->calculatorSnail3->getKey(),
                $this->calculatorVip->getKey()
            ],
            'materials' => [26, 27, 28, 29, 30, 43, 44, 45, 46, 78, 79, 80, 81, 82, 83, 84, 85, 86]
        ];

        foreach ($materials['calculators'] as $calculator) {
            foreach ($materials['materials'] as $material) {
                PivotCalculatorMaterial::query()->create([
                    'calculator_id' => $calculator,
                    'material_id' => $material
                ]);
            }
        }
    }

    private function printSizes(): void
    {
        $A7_74x105 = PrintSize::query()->create([
            'name' => 'A7 (74x105мм)',
            'short_name' => '74x105',
            'height' => 74,
            'width' => 105
        ]);

        $euro_98x210 = PrintSize::query()->create([
            'name' => 'Евро (98x210мм)',
            'short_name' => '98x210',
            'height' => 98,
            'width' => 210
        ]);

        $ps630x210 = PrintSize::query()->create([
            'name' => '630x210 мм',
            'short_name' => '630x210',
            'height' => 630,
            'width' => 210
        ]);

        $ps630x297 = PrintSize::query()->create([
            'name' => '630x297 мм',
            'short_name' => '630x297',
            'height' => 630,
            'width' => 297
        ]);

        $ps400x210 = PrintSize::query()->create([
            'name' => '400x210 мм',
            'short_name' => '400x210',
            'height' => 400,
            'width' => 210
        ]);

        $ps840x297 = PrintSize::query()->create([
            'name' => '840x297 мм',
            'short_name' => '840x297',
            'height' => 840,
            'width' => 297
        ]);

        $sizes = [
            [
                'calculator' => $this->calculatorFlyers->getKey(),
                'sizes' => [46, 48, 51]
            ],
            [
                'calculator' => $this->calculatorBook1->getKey(),
                'sizes' => [47, 49, 51]
            ],
            [
                'calculator' => $this->calculatorEuro2->getKey(),
                'sizes' => [49, 51, $ps630x210->getKey(), $ps630x297->getKey()]
            ],
            [
                'calculator' => $this->calculatorHarmonic2->getKey(),
                'sizes' => [42, 43, $ps630x210->getKey(), $ps630x297->getKey()]
            ],
            [
                'calculator' => $this->calculatorHarmonic3->getKey(),
                'sizes' => [$ps400x210->getKey(), $ps840x297->getKey()]
            ],
            [
                'calculator' => $this->calculatorSnail3->getKey(),
                'sizes' => [$ps400x210->getKey(), $ps840x297->getKey()]
            ],
            [
                'calculator' => $this->calculatorVip->getKey(),
                'sizes' => [$A7_74x105->getKey(), 44, 46, 48, $ps400x210->getKey(), 51, $euro_98x210->getKey(), $ps630x210->getKey(), $ps630x297->getKey()]
            ]
        ];

        foreach ($sizes as $item) {
            foreach ($item['sizes'] as $size) {
                PivotCalculatorPrintSize::query()->create([
                    'calculator_id' => $item['calculator'],
                    'print_size_id' => $size
                ]);
            }
        }
    }

    private function calculators(): void
    {
        $this->calculatorTypeBooklets = CalculatorType::query()->create([
            'name' => 'booklets'
        ]);

        $this->calculatorFlyers = Calculator::query()->create([
            'name' => 'Листовки',
            'description' => 'Листовки',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->calculatorTypeBooklets->getKey()
        ]);

        $this->calculatorBook1 = Calculator::query()->create([
            'name' => 'Буклет "Книжка" 1 сгиб',
            'description' => 'Буклет "Книжка" 1 сгиб',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->calculatorTypeBooklets->getKey()
        ]);

        $this->calculatorEuro2 = Calculator::query()->create([
            'name' => 'Буклет "Евро" 2 сложения',
            'description' => 'Буклет "Евро" 2 сложения',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->calculatorTypeBooklets->getKey()
        ]);

        $this->calculatorHarmonic2 = Calculator::query()->create([
            'name' => 'Буклет "Гармошка" 2 сложения',
            'description' => 'Буклет "Гармошка" 2 сложения',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->calculatorTypeBooklets->getKey()
        ]);

        $this->calculatorHarmonic3 = Calculator::query()->create([
            'name' => 'Буклет "Гармошка" 3 сложения',
            'description' => 'Буклет "Гармошка" 3 сложения',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->calculatorTypeBooklets->getKey()
        ]);

        $this->calculatorSnail3 = Calculator::query()->create([
            'name' => 'Буклет "Улитка" 3 сложения',
            'description' => 'Буклет "Улитка" 3 сложения',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->calculatorTypeBooklets->getKey()
        ]);

        $this->calculatorVip = Calculator::query()->create([
            'name' => 'VIP Буклет',
            'description' => 'VIP Буклет',
            'min_price' => 30,
            'active' => true,
            'calculator_type_id' => $this->calculatorTypeBooklets->getKey()
        ]);
    }
};
