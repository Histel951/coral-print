<?php

use App\Models\Calculator;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $calculatorsMin10 = Calculator::query()->whereIn('name', [
            'Круглые воблеры',
            'Воблеры сложной формы',
            'Круглые бирки',
            'Бирки сложной формы'
        ]);

        $calculatorsMin50 = Calculator::query()->whereIn('name', [
            'Простые воблеры',
            'Хенгеры',
            'Простые бирки'
        ]);

        $calculatorsMin10->each(fn (Calculator $calculator) => $calculator->restrictions()->first()->update([
            'min_size' => 10
        ]));

        $calculatorsMin50->each(fn (Calculator $calculator) => $calculator->restrictions()->first()->update([
            'min_size' => 50
        ]));

        $this->setDefaultSize($calculatorsMin10, 10);
        $this->setDefaultSize($calculatorsMin50, 50);
    }

    private function setDefaultSize(\Illuminate\Database\Eloquent\Builder $calculators, int $size): void
    {
        $calculators->each(function (Calculator $calculator) use ($size): void {
            $newConfig = \App\Models\CalculatorFieldsConfig::query()->create([
                'type' => 'fields_options',
                'value' => [
                    'width_height' => [
                        "defaultWidth" => $size,
                        "defaultHeight" => $size,
                    ],
                    'diameter' => [
                        'default' => $size,
                    ],
                ]
            ]);

            \App\Models\PivotCalculatorFieldsConfig::query()->create([
                'calculator_fields_config_id' => $newConfig->getKey(),
                'calculator_id' => $calculator->id
            ]);
        });
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
