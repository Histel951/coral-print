<?php

use App\Models\FormField;
use Illuminate\Database\Migrations\Migration;

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

        $varnishCheckboxParameters['label'] = 'Выборочный, 1+0';
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
