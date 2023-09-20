<?php

use App\Models\CalculatorFieldsConfig;
use App\Models\FormField;
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
        FormField::query()->create([
            'name' => 'tooltip_print',
            'type' => 'custom',
            'parameters' => ['label' => 'Виды печати (ссылка)']
        ]);

        foreach (\App\Models\CalculatorType::where('name', 'stickers')->get()->first()->calculators as $calc) {
            $calc->fields->first()->value = [...$calc->fields()->first()->value, 'tooltip_print'];
            $calc->fields->first()->save();
        }

        Cache::flush();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        FormField::where('name', 'tooltip_print')->delete();
        $model = CalculatorFieldsConfig::find(1);

        $model->value = [...array_filter($model->value, fn ($v) => $v != 'tooltip_print')];
        $model->save();

        Cache::flush();
    }
};
