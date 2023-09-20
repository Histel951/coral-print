<?php

use App\Models\Calculator;
use App\Models\CalculatorCheckboxConfig;
use App\Models\CalculatorFieldsConfig;
use App\Models\CalculatorType;
use App\Models\Content;
use App\Models\Departure;
use App\Models\FormField;
use App\Models\Hole;
use App\Models\PivotCalculatorCheckboxConfig;
use App\Models\PivotCalculatorColor;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\PivotCalculatorHole;
use App\Models\PivotCalculatorLamination;
use App\Models\PivotCalculatorMaterial;
use App\Models\PivotCalculatorSpecieType;
use App\Models\PivotCalculatorTypeFoilingColor;
use App\Models\PivotWorkAdditional;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Orchid\Attachment\File;

return new /**
 *
 */ class () extends Migration {
    /**
     * ID категории калькулятора
     * @var int
     */
    private int $calcTypeId;

    /**
     * ID калькуляторов
     * @var array
     */
    private array $calcIds = [];

    /**
     * Отверстия
     */
    private const HOLES = ['Без отверстия', 'Сверление d=4 мм', 'Сверление d=5 мм', 'Пикколо серебро d=4мм', 'Пикколо золото d=4мм'];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->addData();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->deleteData();
    }

    /**
     * Добавдяет новые данные
     * @return void
     */
    private function addData()
    {
        try {
            DB::beginTransaction();

            $this->addCalcTypeAndCalcs();
            $this->addFieldsData();
            $this->addFormFields();
            $this->addCalcFieldsAndCheckboxes();
            $this->addCalcData();
            $this->addCalcCountData();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Добавляет категорию, калькуляторы и связывает с контентом
     * @return void
     */
    private function addCalcTypeAndCalcs()
    {
        $this->addCalcType();
        $this->addCalcs();
        $this->addContentCalcType();
    }

    /**
     * Добавляет категорию (тип) калькулятора
     * @return void
     */
    private function addCalcType()
    {
        $this->calcTypeId = CalculatorType::query()->create([
            'name' => 'labels',
        ])->getKey();
    }

    /**
     * Добавляет калькуляторы
     * @return void
     */
    private function addCalcs()
    {
        $this->calcIds['simple'] = Calculator::query()->create([
            'name' => 'Простые бирки',
            'description' => 'Простые бирки',
            'calculator_type_id' => $this->calcTypeId,
        ])->getKey();

        $this->calcIds['circle'] = Calculator::query()->create([
            'name' => 'Круглые бирки',
            'description' => 'Круглые бирки',
            'calculator_type_id' => $this->calcTypeId,
        ])->getKey();

        $this->calcIds['complex'] = Calculator::query()->create([
            'name' => 'Бирки сложной формы',
            'description' => 'Бирки сложной формы',
            'calculator_type_id' => $this->calcTypeId,
        ])->getKey();

        $this->calcIds['simpleWobblers'] = Calculator::query()->create([
            'name' => 'Простые воблеры',
            'description' => 'Простые воблеры',
            'calculator_type_id' => $this->calcTypeId,
        ])->getKey();

        $this->calcIds['circleWobblers'] = Calculator::query()->create([
            'name' => 'Круглые воблеры',
            'description' => 'Круглые воблеры',
            'calculator_type_id' => $this->calcTypeId,
        ])->getKey();

        $this->calcIds['complexWobblers'] = Calculator::query()->create([
            'name' => 'Воблеры сложной формы',
            'description' => 'Воблеры сложной формы',
            'calculator_type_id' => $this->calcTypeId,
        ])->getKey();

        $this->calcIds['hangers'] = Calculator::query()->create([
            'name' => 'Хенгеры',
            'description' => 'Хенгеры',
            'calculator_type_id' => $this->calcTypeId,
        ])->getKey();
    }

    /**
     * Связывает категорию с контентом
     * @return void
     */
    private function addContentCalcType()
    {
        Content::where('content_id', 3167)->update(['calc_type' => $this->calcTypeId]);
    }

    /**
     * Добавляет новые данные (для опшенов в селектах и пр)
     * @return void
     */
    private function addFieldsData()
    {
        $this->addHoles();
    }

    /**
     * Добавляет данные по Отверстиям
     * @return void
     */
    private function addHoles()
    {
        foreach (self::HOLES as $hole) {
            Hole::query()->create([
                'name' => $hole
            ]);
        }
    }

    /**
     * Добавляет новые поля в конфиг полей
     * @return void
     */
    private function addFormFields()
    {
        $fields = [
            "folded" => [
                "formField" => "folded",
                "label" => "Изделие со сложением",
                "labelModalLink" => "folded-modal",
                "info" => false,
                "checked" => 0,
                "type" => "checkbox"
            ],
            "hole" => [
                "type" => "select",
                "formField" => "hole",
                "dataField" => "hole",
                "label" => "Отверстие"
            ],
        ];

        foreach ($fields as $name => $field) {
            $parameters = $field;
            unset($parameters['type']);

            FormField::query()->create([
                'type' => $field['type'],
                'name' => $name,
                'parameters' => $parameters
            ]);
        }
    }

    /**
     * Связывает конкретные калькуляторы с конкретными полями и чекбоксами
     * @return void
     */
    private function addCalcFieldsAndCheckboxes()
    {
        $this->addCalcFields();
        $this->addCalcCheckboxes();
    }

    /**
     * Связывает конкретные калькуляторы с конкретными полям
     * @return void
     */
    private function addCalcFields()
    {
        $fields = [
            [
                'calculators' => [$this->calcIds['simple'], $this->calcIds['complex']],
                'type' => 'fields',
                'value' => ['width_height', 'product_count_types', 'color', 'material', 'lam', 'foiling_face', 'foiling_back', 'hole']
            ],
            [
                'calculators' => [$this->calcIds['simpleWobblers'], $this->calcIds['complexWobblers'], $this->calcIds['hangers']],
                'type' => 'fields',
                'value' => ['width_height', 'product_count_types', 'color', 'material', 'lam', 'foiling_face', 'foiling_back']
            ],
            [
                'calculators' => [$this->calcIds['circle']],
                'type' => 'fields',
                'value' => ['diameter', 'product_count_types', 'color', 'material', 'lam', 'foiling_face', 'foiling_back', 'hole']
            ],
            [
                'calculators' => [$this->calcIds['circleWobblers']],
                'type' => 'fields',
                'value' => ['diameter', 'product_count_types', 'color', 'material', 'lam', 'foiling_face', 'foiling_back']
            ],
            [
                'calculators' => [$this->calcIds['simple'], $this->calcIds['complex'], $this->calcIds['simpleWobblers'], $this->calcIds['complexWobblers'], $this->calcIds['hangers']],
                'type' => 'fields_options',
                'value' => [
                    'width_height' => [
                        "defaultWidth" => 6,
                        "defaultHeight" => 6,
                    ],
                    'diameter' => [
                        'default' => 6,
                    ],
                ]
            ],
            [
                'calculators' => [$this->calcIds['simple'], $this->calcIds['circle'], $this->calcIds['complex'],
                    $this->calcIds['simpleWobblers'], $this->calcIds['circleWobblers'], $this->calcIds['complexWobblers'],
                    $this->calcIds['hangers']],
                'type' => 'fields_options',
                'value' => [
                    'width_height' => [
                        "defaultWidth" => 6,
                        "defaultHeight" => 6,
                    ],
                    'diameter' => [
                        'default' => 6,
                    ],
                ]
            ],
            [
                'calculators' => [$this->calcIds['simple'], $this->calcIds['circle'], $this->calcIds['complex'],
                    $this->calcIds['simpleWobblers'], $this->calcIds['circleWobblers'], $this->calcIds['complexWobblers'],
                    $this->calcIds['hangers']],
                'type' => 'fields_options',
                'value' => [
                    'product_count_types' => [
                        'default' => 50,
                    ],
                ]
            ],
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

    /**
     * Связывает конкретные калькуляторы с конкретными чекбоксами
     * @return void
     */
    private function addCalcCheckboxes()
    {
        $fields = [
            [
                'calculators' => [$this->calcIds['simple']],
                'checkboxes' => ['rounding_corners', 'folded'],
            ],
            [
                'calculators' => [$this->calcIds['simpleWobblers']],
                'checkboxes' => ['rounding_corners'],
            ],
        ];

        foreach ($fields as $item) {
            $newCheckboxesConfig = CalculatorCheckboxConfig::query()->create([
                'value' => $item['checkboxes']
            ]);

            foreach ($item['calculators'] as $calculatorId) {
                PivotCalculatorCheckboxConfig::query()->create([
                    'calculator_id' => $calculatorId,
                    'calculator_checkbox_config_id' => $newCheckboxesConfig->getKey()
                ]);
            }
        }
    }

    /**
     * Связывает конкретные калькуляторы с данными конкретных полей
     * @return void
     */
    private function addCalcData()
    {
        $this->addCalcColors();
        $this->addCalcMaterials();
        $this->addCalcLaminations();
        $this->addCalcFoilingColors();
        $this->addCalcHoles();
        $this->addCalcImages();
    }

    /**
     * Связывает калькуляторы и цветность
     * @return void
     */
    private function addCalcColors()
    {
        $colors = [10, 11];

        foreach ($this->calcIds as $calcId) {
            foreach ($colors as $colorId) {
                PivotCalculatorColor::query()->create([
                    'calculator_id' => $calcId,
                    'color_id' => $colorId,
                ]);
            }
        }
    }

    /**
     * Связывает калькуляторы и материалы
     * @return void
     */
    private function addCalcMaterials()
    {
        $materials = [
            44, 45, 46, 79, 82, 84, 85, 86, 87, 88, 89,
        ];

        foreach ($this->calcIds as $calcId) {
            foreach ($materials as $materialId) {
                PivotCalculatorMaterial::query()->create([
                    'calculator_id' => $calcId,
                    'material_id' => $materialId,
                ]);
            }
        }
    }

    /**
     * Связывает калькуляторы и ламинацию
     * @return void
     */
    private function addCalcLaminations()
    {
        $laminations = [
            111, 112, 113, 114, 115, 116, 117, 119, 120
        ];

        foreach ($this->calcIds as $calcId) {
            foreach ($laminations as $laminationId) {
                PivotCalculatorLamination::query()->create([
                    'calculator_id' => $calcId,
                    'lamination_id' => $laminationId,
                ]);
            }
        }
    }

    /**
     * Связывает калькуляторы и фаольгу
     * @return void
     */
    private function addCalcFoilingColors()
    {
        $foilingColors = [
            63, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87
        ];

        foreach ($foilingColors as $foilingColorId) {
            PivotCalculatorTypeFoilingColor::query()->create([
                'calculator_type_id' => $this->calcTypeId,
                'foiling_color_id' => $foilingColorId,
            ]);
        }
    }

    /**
     * Связывает калькуляторы и отверстия
     * @return void
     */
    private function addCalcHoles()
    {
        $holes = Hole::query()->get()->pluck('id')->toArray();

        foreach ($this->calcIds as $calcId) {
            foreach ($holes as $holeId) {
                PivotCalculatorHole::query()->create([
                    'calculator_id' => $calcId,
                    'hole_id' => $holeId,
                ]);
            }
        }
    }

    /**
     * Добавляет иконки калькуляторам
     * @return void
     */
    private function addCalcImages()
    {
        $calcImages = [
            $this->calcIds['simple'] =>
                [
                    'name' => 'Icon-Tag-regular.svg',
                    'extension' => 'svg',
                    'path' => 'images/calculators/Icon-Tag-regular.svg'
                ],
            $this->calcIds['circle'] =>
                [
                    'name' => 'Icon-Tag-round.svg',
                    'extension' => 'svg',
                    'path' => 'images/calculators/Icon-Tag-round.svg'
                ],
            $this->calcIds['complex'] =>
                [
                    'name' => 'Icon-Tag-complex-form.svg',
                    'extension' => 'svg',
                    'path' => 'images/calculators/Icon-Tag-complex-form.svg'
                ],
            $this->calcIds['simpleWobblers'] =>
                [
                    'name' => 'Icon-Tag-Wobbler-regular.svg',
                    'extension' => 'svg',
                    'path' => 'images/calculators/Icon-Tag-Wobbler-regular.svg'
                ],
            $this->calcIds['circleWobblers'] =>
                [
                    'name' => 'Icon-Tag-Wobbler-round.svg',
                    'extension' => 'svg',
                    'path' => 'images/calculators/Icon-Tag-Wobbler-round.svg'
                ],
            $this->calcIds['complexWobblers'] =>
                [
                    'name' => 'Icon-Tag-Wobbler-complex-form.svg',
                    'extension' => 'svg',
                    'path' => 'images/calculators/Icon-Tag-Wobbler-complex-form.svg'
                ],
            $this->calcIds['hangers'] =>
                [
                    'name' => 'Icon-Tag-Hanger.svg',
                    'extension' => 'svg',
                    'path' => 'images/calculators/Icon-Tag-Hanger.svg'
                ],

        ];

        foreach ($calcImages as $calculatorId => $item) {
            $file = new UploadedFile(public_path($item['path']), $item['name']);
            $attachment = (new File($file))->load();

            Calculator::find($calculatorId)->update([
                'image_id' => $attachment->getKey()
            ]);
        }
    }

    /**
     * Добавляет данные, необходимые для расчета цены
     * @return void
     */
    private function addCalcCountData()
    {
        $this->addCalcWorkAdditionals();
        $this->addCalcSpeciesTypes();
        $this->addCalcDepartures();
    }

    /**
     * Связывает калькуляторы и доп работы
     * @return void
     */
    private function addCalcWorkAdditionals()
    {
        $works = [
            'big' => 18,
            'pikolo' => 19,
            'prilbig' => 21,
            'lam25' => 28,
            'lam75' => 29,
            'prillam' => 31,
            'prillamYDFM' => 32,
            'lamsoftmYDFM' => 37,
            'virubka' => 46,
            'slozform' => 48,
            'priladkametok' => 51,
            'prilpech' => 54,
            'rezviz' => 56,
            'prilsverl' => 60,
            'sverlenie' => 61,
            'prilskrugl' => 65,
            'skruglenie' => 66,
            'prilfalc' => 67,
            'falc' => 68,
            'prilfolga' => 77,
            'folgaspech' => 79,
            'nozkawobler' => 87,
        ];

        $fields = [
            [
                'calculator_id' => [$this->calcIds['simple'], $this->calcIds['simpleWobblers'], $this->calcIds['circle'],
                    $this->calcIds['circleWobblers'], $this->calcIds['complex'], $this->calcIds['complexWobblers'], $this->calcIds['hangers']],
                'work_additional_id' => [$works['prilpech']],
            ],
            [
                'calculator_id' => [$this->calcIds['simple'], $this->calcIds['circle'], $this->calcIds['complex']],
                'hole_id' => [2, 3],
                'work_additional_id' => [$works['prilsverl'], $works['sverlenie']],
            ],
            [
                'calculator_id' => [$this->calcIds['simple'], $this->calcIds['circle'], $this->calcIds['complex']],
                'hole_id' => [4, 5],
                'work_additional_id' => [$works['pikolo']],
            ],
            [
                'calculator_id' => [$this->calcIds['simple'], $this->calcIds['simpleWobblers'], $this->calcIds['circle'],
                    $this->calcIds['circleWobblers'], $this->calcIds['complex'], $this->calcIds['complexWobblers'], $this->calcIds['hangers']],
                'lamination_id' => [112, 113, 114, 115],
                'work_additional_id' => [$works['prillamYDFM'], $works['lam25']],
            ],
            [
                'calculator_id' => [$this->calcIds['simple'], $this->calcIds['simpleWobblers'], $this->calcIds['circle'],
                    $this->calcIds['circleWobblers'], $this->calcIds['complex'], $this->calcIds['complexWobblers'], $this->calcIds['hangers']],
                'lamination_id' => [113, 115],
                'work_additional_id' => [$works['lam25']],
            ],
            [
                'calculator_id' => [$this->calcIds['simple'], $this->calcIds['simpleWobblers'], $this->calcIds['circle'],
                    $this->calcIds['circleWobblers'], $this->calcIds['complex'], $this->calcIds['complexWobblers'], $this->calcIds['hangers']],
                'lamination_id' => [116, 117],
                'work_additional_id' => [$works['prillamYDFM'], $works['lamsoftmYDFM']],
            ],
            [
                'calculator_id' => [$this->calcIds['simple'], $this->calcIds['simpleWobblers'], $this->calcIds['circle'],
                    $this->calcIds['circleWobblers'], $this->calcIds['complex'], $this->calcIds['complexWobblers'], $this->calcIds['hangers']],
                'lamination_id' => [117],
                'work_additional_id' => [$works['lamsoftmYDFM']],
            ],
            [
                'calculator_id' => [$this->calcIds['simple'], $this->calcIds['simpleWobblers'], $this->calcIds['circle'],
                    $this->calcIds['circleWobblers'], $this->calcIds['complex'], $this->calcIds['complexWobblers'], $this->calcIds['hangers']],
                'lamination_id' => [119, 120],
                'work_additional_id' => [$works['prillam'], $works['lam75']],
            ],
            [
                'calculator_id' => [$this->calcIds['simple'], $this->calcIds['simpleWobblers'], $this->calcIds['circle'],
                    $this->calcIds['circleWobblers'], $this->calcIds['complex'], $this->calcIds['complexWobblers'], $this->calcIds['hangers']],
                'foiling_face' => [true],
                'work_additional_id' => [$works['prilfolga'], $works['folgaspech']],
            ],
            [
                'calculator_id' => [$this->calcIds['simple'], $this->calcIds['simpleWobblers'], $this->calcIds['circle'],
                    $this->calcIds['circleWobblers'], $this->calcIds['complex'], $this->calcIds['complexWobblers'], $this->calcIds['hangers']],
                'foiling_back' => [true],
                'work_additional_id' => [$works['prilfolga'], $works['folgaspech']],
            ],
            [
                'calculator_id' => [$this->calcIds['simpleWobblers'], $this->calcIds['circleWobblers'], $this->calcIds['complexWobblers']],
                'work_additional_id' => [$works['nozkawobler']],
            ],
            [
                'calculator_id' => [$this->calcIds['simple'], $this->calcIds['simpleWobblers']],
                'work_additional_id' => [$works['rezviz']],
            ],
            [
                'calculator_id' => [$this->calcIds['simple'], $this->calcIds['simpleWobblers']],
                'is_rounding_corners' => true,
                'work_additional_id' => [$works['prilskrugl'], $works['skruglenie']],
            ],
            [
                'calculator_id' => [$this->calcIds['circle'], $this->calcIds['circleWobblers'], $this->calcIds['complex'],
                    $this->calcIds['complexWobblers'], $this->calcIds['hangers']],
                'work_additional_id' => [$works['priladkametok'], $works['virubka']],
            ],
            [
                'calculator_id' => [$this->calcIds['complex'], $this->calcIds['complexWobblers'], $this->calcIds['hangers']],
                'work_additional_id' => [$works['slozform']],
            ],
            [
                'calculator_id' => [$this->calcIds['simple']],
                'is_folded' => true,
                'work_additional_id' => [$works['prilfalc'], $works['falc'], $works['prilbig'], $works['big']],
            ],

        ];

        foreach ($fields as $params) {
            $collection = collect($params);
            $values = $collection->values()->map(fn ($v) => collect($v));
            $rows = $values->shift()->crossJoin(...$values)->map(fn ($v) => array_combine($collection->keys()->toArray(), $v))->toArray();

            PivotWorkAdditional::query()->insert($rows);
        }
    }

    /**
     * Связывает калькуляторы и печать
     * @return void
     */
    private function addCalcSpeciesTypes()
    {
        foreach ($this->calcIds as $calcId) {
            PivotCalculatorSpecieType::query()->create([
                'calculator_id' => $calcId,
                'specie_type_id' => 30,
            ]);
        }
    }

    /**
     * Связывает калькуляторы и departure (margin)
     * @return void
     */
    private function addCalcDepartures()
    {
        foreach ([$this->calcIds['simple'], $this->calcIds['simpleWobblers']] as $calcId) {
            Departure::query()->create([
                'calculator_id' => $calcId,
                'value' => 2,
            ]);
        }
    }

    /**
     * Удаляет добавленные данные
     * @return void
     */
    private function deleteData()
    {
        $this->setCalcIds();

        try {
            DB::beginTransaction();

            $this->deleteCalcCountData();
            $this->deleteCalcData();
            $this->deleteCalcFieldsAndCheckboxes();
            $this->deleteFormFields();
            $this->deleteFieldsData();
            $this->deleteCalcTypeAndCalcs();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Устанавливает категорию калькулятора
     * @return void
     */
    private function setCalcIds()
    {
        $this->calcTypeIds = CalculatorType::where('name', 'labels')->get()->first()->calculators->toArray();
    }

    /**
     * Удаляет данные, необходимые для расчета цены
     * @return void
     */
    private function deleteCalcCountData()
    {
        $this->deleteCalcWorkAdditionals();
        $this->deleteCalcSpeciesTypes();
        $this->deleteCalcDepartures();
    }

    /**
     * Отвяызвает калькуляторы от доп работ
     * @return void
     */
    private function deleteCalcWorkAdditionals()
    {
        PivotWorkAdditional::query()->whereIn('calculator_id', $this->calcIds)->delete();
    }

    /**
     * Отвязывает калькуляторы от печати
     * @return void
     */
    private function deleteCalcSpeciesTypes()
    {
        PivotCalculatorSpecieType::query()->whereIn('calculator_id', $this->calcIds)->delete();
    }

    /**
     * Отвязывает калькуляторы от departure (margin)
     * @return void
     */
    private function deleteCalcDepartures()
    {
        Departure::query()->whereIn('calculator_id', $this->calcIds)->delete();
    }

    /**
     * Отвязывает конкретные калькуляторы от данных конкретных полей
     * @return void
     */
    private function deleteCalcData()
    {
        $this->deleteCalcColors();
        $this->deleteCalcMaterials();
        $this->deleteCalcLaminations();
        $this->deleteCalcFoilingColors();
        $this->deleteCalcHoles();
//        $this->deleteCalcImages();
    }

    /**
     * Отвязывает калькуляторы и цветность
     * @return void
     */
    private function deleteCalcColors()
    {
        PivotCalculatorFieldsConfig::query()->whereIn('calculator_id', $this->calcIds)->delete();
    }

    /**
     * Отвязывает калькуляторы и материалы
     * @return void
     */
    private function deleteCalcMaterials()
    {
        PivotCalculatorMaterial::query()->whereIn('calculator_id', $this->calcIds)->delete();
    }

    /**
     * Отвязывает калькуляторы и ламинацию
     * @return void
     */
    private function deleteCalcLaminations()
    {
        PivotCalculatorLamination::query()->whereIn('calculator_id', $this->calcIds)->delete();
    }

    /**
     * Отвязывает калькуляторы и фаольгу
     * @return void
     */
    private function deleteCalcFoilingColors()
    {
        PivotCalculatorTypeFoilingColor::query()->whereIn('calculator_id', $this->calcIds)->delete();
    }

    /**
     * Отвязывает калькуляторы и отверстия
     * @return void
     */
    private function deleteCalcHoles()
    {
        PivotCalculatorHole::query()->whereIn('calculator_id', $this->calcIds)->delete();
    }

    /**
     * Отвязывает иконки от калькуляторов
     * @return void
     */
    private function deleteCalcImages()
    {
        Calculator::find($this->calcIds)->update([
            'image_id' => null
        ]);
    }

    /**
     * Отвязывает конкретные калькуляторы от конкретных полей и чекбоксов
     * @return void
     */
    private function deleteCalcFieldsAndCheckboxes()
    {
        $this->deleteCalcFields();
        $this->deleteCalcCheckboxes();
    }

    /**
     * Отвязывает конкретные калькуляторы от конкретных полей
     * @return void
     */
    private function deleteCalcFields()
    {
        $ids = PivotCalculatorFieldsConfig::query()->whereIn('id', $this->calcIds)->get()->pluck('calculator_fields_config_id')->toArray();

        PivotCalculatorFieldsConfig::query()->whereIn('calculator_id', $this->calcIds)->delete();
        CalculatorCheckboxConfig::query()->whereIn('id', $ids)->delete();
    }

    /**
     * Отвязывает конкретные калькуляторы от конкретных чекбоксов
     * @return void
     */
    private function deleteCalcCheckboxes()
    {
        $ids = PivotCalculatorCheckboxConfig::query()->whereIn('id', $this->calcIds)->get()->pluck('calculator_checkbox_config_id')->toArray();

        PivotCalculatorCheckboxConfig::query()->whereIn('calculator_id', $this->calcIds)->delete();
        CalculatorFieldsConfig::query()->whereIn('id', $ids)->delete();
    }

    /**
     * Удаялет новые поля из конфига полей
     * @return void
     */
    private function deleteFormFields()
    {
        CalculatorFieldsConfig::query()->whereIn('calculator_id', $this->calcIds)->delete();
    }

    /**
     * Удаялет новые данные (для опшенов в селектах и пр)
     * @return void
     */
    private function deleteFieldsData()
    {
        $this->deleteHoles();
    }

    /**
     * Удаляет данные по Отверстиям
     * @return void
     */
    private function deleteHoles()
    {
        Hole::query()->whereIn('name', self::HOLES)->delete();
    }

    /**
     * Удаляет категорию, калькуляторы и связывает с контентом
     * @return void
     */
    private function deleteCalcTypeAndCalcs()
    {
        $this->deleteContentCalcType();
        $this->deleteCalcs();
        $this->deleteCalcType();
    }

    /**
     * Отвязывает категорию от контента
     * @return void
     */
    private function deleteContentCalcType()
    {
        Content::where('content_id', 3167)->update(['calc_type' => null]);
    }

    /**
     * Удаляет калькуляторы
     * @return void
     */
    private function deleteCalcs()
    {
        Calculator::query()->whereIn('id', $this->calcIds)->delete();
    }

    /**
     * Удаляет категорию (тип) калькулятора
     * @return void
     */
    private function deleteCalcType()
    {
        CalculatorType::query()->where('name', 'labels')->delete();
    }
};
