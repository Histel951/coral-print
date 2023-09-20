<?php

use App\Models\CalculatorFieldsConfig;
use App\Models\CalculatorType;
use App\Models\PivotCalculatorFieldsConfig;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    private Collection $calcs;
    private array $calcIds;


    public function __construct()
    {
        $this->calcs = CalculatorType::where('name', 'businessCards')->get()->first()->calculators;
        ;
        $this->calcIds = $this->calcs->pluck('id')->toArray();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $fields = [
            [
                'calculators' => $this->calcIds,
                'type' => 'fields_options',
                'value' => [
                    'product_count_types' => [
                        'label' => 'Тираж',
                        'formTypesField' => 'quantity_types',
                        'formField' => 'product_count',
                        'type' => 'count',
                        'numbersOnly' => true,
                        'predefinedValues' => true,
                        'hideTypes' => true,
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
        //
    }
};
