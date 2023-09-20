<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\FormField;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $varnishCheckbox = FormField::query()->find(35);
        $varnishCheckboxParameters = $varnishCheckbox->parameters;

        $varnishCheckboxParameters['label'] = 'Выборочный лак, 1+0';
        $varnishCheckbox?->update([
            'parameters' => $varnishCheckboxParameters
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
