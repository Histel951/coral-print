<?php

use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $defaultWidth = [
            'calculators' => [3822, 3820, 3824],
            'width' => 1100
        ];

        foreach ($defaultWidth['calculators'] as $calculatorId) {
            \App\Models\Calculator::query()->find($calculatorId)->update([
                'width_without_print' => $defaultWidth['width']
            ]);
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
