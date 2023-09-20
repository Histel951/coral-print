<?php

use App\Models\CalculatorFieldsConfig;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\PivotCalculatorSprintPosition;
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
        $sprintPositions = PivotCalculatorSprintPosition::query()->where('calculator_id', 3858);

        $sprintPositions->get()->map(fn (PivotCalculatorSprintPosition $sprintPosition) => PivotCalculatorSprintPosition::query()->create([
            'calculator_id' => 3859,
            'sprint_position_id' => $sprintPosition->sprint_position_id
        ]));

        PivotCalculatorFieldsConfig::query()->find(19)->delete();
        PivotCalculatorFieldsConfig::query()->find(25)->delete();

        $config = CalculatorFieldsConfig::query()->find(11);
        $newConfig = CalculatorFieldsConfig::query()->create([
            'type' => 'fields',
            'value' => Arr::collapse([
                $config->value,
                [
                    'sprint_position'
                ]
            ])
        ]);

        PivotCalculatorFieldsConfig::query()->create([
            'calculator_id' => 3859,
            'calculator_fields_config_id' => $newConfig->getKey()
        ]);
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
