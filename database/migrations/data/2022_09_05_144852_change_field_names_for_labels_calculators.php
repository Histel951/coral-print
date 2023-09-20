<?php

use App\Models\CalculatorFieldsConfig;
use App\Models\CalculatorType;
use App\Models\PivotCalculatorFieldsConfig;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    private Collection $calcs;
    private array $calcIds;

    /**
     * @param array $calcs
     * @param array $calcIds
     */
    public function __construct()
    {
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->calcs = CalculatorType::where('name', 'labels')->get()->first()->calculators;

        $this->calcIds = $this->calcs->pluck('id')->toArray();

        foreach ($this->calcs as $calc) {
            $calc->colors()->sync([16, 18]);
        }

        $fields = [
            [
                'calculators' => $this->calcIds,
                'type' => 'fields_options',
                'value' => [
                    'product_count_types' => [
                        'label' => 'Тираж',
                        'formTypesField' => 'quantity_types',
                        'formField' => 'product_count',
                        'type' => 'input',
                        'numbersOnly' => true,
                        'postText' => 'шт',
                    ],
                    'material' => [
                        'label' => 'Бумага',
                    ],
                    'color' => [
                        'label' => 'Печать',
                    ],
                ]
            ],
            [
                'calculators' => $this->calcIds,
                'type' => 'checkboxes_options',
                'value' => [
                    'folded' => [
                        'label' => 'Бирки со сложением',
                    ],
                ]
            ],
        ];

        foreach ($fields as $item) {
            if (!CalculatorFieldsConfig::where('value', $item['value'])->where('type', $item['type'])->count()) {
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->calcs = CalculatorType::where('name', 'labels')->get()->first()->calculators;

        $this->calcIds = $this->calcs->pluck('id')->toArray();

        foreach ($this->calcs as $calc) {
            $calc->colors()->sync([]);
        }
    }
};
