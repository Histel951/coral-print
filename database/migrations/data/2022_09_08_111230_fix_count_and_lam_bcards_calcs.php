<?php

use App\Models\CalculatorFieldsConfig;
use App\Models\PivotCalculatorFieldsConfig;
use App\Models\PivotCalculatorLamination;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $id = PivotCalculatorFieldsConfig::query()
            ->where('calculator_id', 3831)
            ->orderBy('calculator_fields_config_id', 'desc')
            ->get()
            ->first()->calculator_fields_config_id;

        $model = CalculatorFieldsConfig::find($id);
        $value = $model->value;
        $value['product_count_types']['postText'] = false;
        $model->value = $value;
        $model->save();

        PivotCalculatorLamination::where('lamination_id', 121)->delete();
        Cache::flush();
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
