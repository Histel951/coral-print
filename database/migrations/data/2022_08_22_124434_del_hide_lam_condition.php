<?php

use App\Models\CalculatorFieldsConfig;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $config = CalculatorFieldsConfig::query()->find(20);
        $value = $config->value;

        unset($value['lam']['conditions']['visible']);
        $config->update([
            'value' => $value
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
